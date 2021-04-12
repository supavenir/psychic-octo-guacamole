<?php
namespace controllers;
use libs\BuildResults;
use Ajax\service\JString;
use libs\GUI;
use Ubiquity\utils\http\USession;
use Ubiquity\utils\base\UArray;

 /**
 * Controller Main
 * @property \Ajax\php\ubiquity\JsUtils $jquery
 **/
class Main extends ControllerBase{
	/**
	 * 
	 * @var GUI
	 */
	private $gui;
	
	private static $resultFile="results.orm.log";
	private static $outputDirectory=ROOT."./../output/";

	private $fw;

	private function getAllTests(){
		$dirs=glob(self::$outputDirectory."public/*");
		$tests=[];
		foreach ($dirs as $dir) {
			if (\is_dir($dir)) {
				$title = \basename($dir);
				$file = $dir . DS . self::$resultFile;
				if(file_exists($file)){
					$tests[]=$title;
				}
			}
		}
		return $tests;
	}

	public function initialize(){
		parent::initialize();
		$this->gui=new GUI($this->jquery->semantic());
	}

	public function index(){
		$gui=$this->gui;
		$allElements=[];
		$allResults=$this->getDatasArray(USession::getBoolean('reverse'));
		$chartType='ColumnChart';
		$tabs=$this->jquery->semantic()->htmlTab("tabs");
		$reverse=USession::get('reverse');
		foreach ($allResults as $title=>$result){
			$context = JString::cleanIdentifier($title);
			$dir=self::$outputDirectory."public/".$title;

			$elements=BuildResults::makeAllGraphs(function($id) use ($result){
				$data = array();
				$data[] = array('', $id, array('role' => 'style'));  // header

				foreach ($result as $fw => $res) {
					$data[] = array($fw, $res[$id], BuildResults::getBarColor($fw));
				}
				return $data;
			}, $context,$chartType);
			$kElements=\array_keys($elements);
			$allElements=\array_merge($allElements, $kElements);
			$content=$gui->createInternalMenu($context, $kElements);
			if($reverse) {
				$content .= $gui->displayIniFile($title, "spec-reverse-" . $context, $dir .".ini", "chart bar", "olive floating");
			}
			$content.=$gui->displayIniFile($title,"spec-".$context,$dir.DS."specifications.ini","database","info");
			$content.=$gui->displayIniFile($title,"spec-config-".$context,$dir.DS."configuration.ini","settings","warning");
			foreach ($elements as $element){
				$this->jquery->exec($element["chart"],true);
				$content.=$element["div"];
			}
			$title=$gui->replaceHtml($title);
			$title=\str_replace('-small','<span class="ui mini olive circular label">S</span>',$title);
			$title=\str_replace('-medium','<span class="ui mini yellow circular label">M</span>',$title);
			$title=\str_replace('-large','<span class="ui mini orange circular label">L</span>',$title);
			$content=$gui->replaceHtml($content);
			$tab=$tabs->addTab($title, $content);
		}
		if(($urls=$gui->getUrls(self::$outputDirectory."urls.log"))!==false){
			$urls="<div class='ui segment'>".$urls."</div>";
		}
		
		$gui->displayIniFile($title,"server-config",self::$outputDirectory."configuration.ini","");
		$gui->frmFields($allElements);
		$gui->frmDatas($this->fw,$this->getAllTests());
		$this->jquery->execAtLast(BuildResults::loadGoogleChart($chartType));
		$this->jquery->click(".select-fields","$('#div-fields').toggle();");
		$this->jquery->click(".select-datas","$('#div-datas').toggle();");
		$this->jquery->getHref("a[data-target]","",["ajaxTransition"=>"scale"]);
		$this->jquery->renderView('Main/index.html',["urls"=>$urls]);
	}

	public function getDatasArray(?bool $reverse=false):array{
		$fws=USession::get("fws",[]);
		$tests=USession::get('tests',[]);
		$filteredTests=USession::exists('tests');
		$dirs=glob(self::$outputDirectory."public/*");
		$allResults=[];
		foreach ($dirs as $dir) {
			if (\is_dir($dir)) {
				$title = \basename($dir);
				$file = $dir . DS . self::$resultFile;
				if ((!$filteredTests || \array_search($title,$tests)!==false) && \file_exists($file)) {
					$result = BuildResults::parseResults($file);
					$allResults[$title] = $result;
				}
			}
		}
		if(\count($allResults)>0){
			$this->fw=\array_keys(\current($allResults));
		}
		if($reverse){
			$filtered=USession::exists('fws');
			$allResultsReverse=[];
			foreach ($allResults as $key=>$result){
				foreach ($result as $fw=>$fwResult){
					if(!$filtered || \array_search($fw,$fws)!==false) {
						$allResultsReverse[$fw][$key] = $fwResult;
					}
				}
			}
			return $allResultsReverse;
		}
		if(USession::exists('fws')){
			$toRemoveFws=\array_diff($this->fw,$fws);
			foreach ($allResults as $title=>$result){
				foreach ($toRemoveFws as $toRemoveFw){
					unset($allResults[$title][$toRemoveFw]);
				}
			}
		}
		return $allResults;
	}
	
	public function filterFields(){
		$fieldsToDisplay=UArray::iRemove(\explode(",", $_POST["fields"]), "");
		if(\count($fieldsToDisplay)>0) {
			USession::set("fields", $fieldsToDisplay);
		}else{
			USession::delete('fields');
			$fieldsToDisplay=['rps','time','memory','file','queries','rows'];
		}
		if(\count($fieldsToDisplay)===0){
			$this->jquery->execAtLast('$("._field").show();');
		}else{
			$selectors=\array_map(function($elm){return ".".$elm;}, $fieldsToDisplay);
			$this->jquery->execAtLast('$("._field").hide();$("'.\implode(", ",$selectors).'").show();');
			
		}
		$this->jquery->execAtLast("$('#div-fields').hide();");
		echo $this->jquery->compile();
	}

	public function filterDatas(){
		$fwsToDisplay=UArray::iRemove(\explode(",", $_POST["fws"]), "");
		$testsToDisplay=UArray::iRemove(\explode(",", $_POST["tests"]), "");
		if(\count($fwsToDisplay)>0) {
			USession::set("fws", $fwsToDisplay);
		}else{
			USession::delete("fws");
		}
		if(\count($testsToDisplay)>0) {
			USession::set("tests", $testsToDisplay);
		}else{
			USession::delete("tests");
		}
		USession::set('reverse',isset($_POST['ck-reverse']));
		$this->index();
	}
	
	public static function displayField($elementId){
		$fieldsToDisplay=USession::get("fields",['rps','time']);
		if(\count($fieldsToDisplay)===0){
			return true;
		}
		return \array_search($elementId, $fieldsToDisplay)!==false;
	}
	
	public static function getFieldsToDisplay(){
		$fieldsToDisplay=USession::get("fields",['rps','time']);
		return \implode(",", $fieldsToDisplay);
	}

	public static function getFwsToDisplay(){
		$fwsToDisplay=USession::get("fws",[]);
		return \implode(",", $fwsToDisplay);
	}

	public static function getTestsToDisplay(){
		$testsToDisplay=USession::get("tests",[]);
		return \implode(",", $testsToDisplay);
	}
	
	public function datas(){
		echo $this->gui->loadMdFile("datas", "datas.md");
	}
	
	public function doIt(){
		echo $this->gui->loadMdFile("doit", "doit.md");
	}

}