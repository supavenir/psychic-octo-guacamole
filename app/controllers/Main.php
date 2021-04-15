<?php
namespace controllers;
use libs\BuildResults;
use Ajax\service\JString;
use libs\GUI;
use Ubiquity\utils\http\URequest;
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

	private $directories;

	private function getAllTests($activeDir){
		$dirs=glob(self::$outputDirectory.$activeDir."/*");
		$tests=[];
		foreach ($dirs as $dir) {
			if (\is_dir($dir)) {
				$title = \basename($dir);
				$file = $dir . DS . self::$resultFile;
				if(\file_exists($file)){
					$tests[]=$title;
				}
			}
		}
		return $tests;
	}

	public function initialize(){
		parent::initialize();
		$this->gui=new GUI($this->jquery->semantic());
		if(!URequest::isAjax()){
			$this->jquery->getHref("a[data-target]","",["ajaxTransition"=>"scale",'listenerOn'=>'body']);
			$this->jquery->click(".select-datas","$('#div-datas').toggle();",listenerOn: 'body');
			$this->jquery->click(".select-fields","$('#div-fields').toggle();",listenerOn: 'body');
		}
	}

	public function index(){
		$gui=$this->gui;
		$activeDir=$this->getActiveDir();
		$gui->getDirectoriesMenu($this->directories,$activeDir);
		$this->results($activeDir);

		$gui->displayIniFile($title,"server-config",self::$outputDirectory."configuration.ini","");
		$gui->getUrls(self::$outputDirectory."urls.log");
		$this->jquery->renderView('Main/index.html');
	}

	private function results($activeDir){
		$gui=$this->gui;
		$allElements=[];
		$allResults=$this->getDatasArray($activeDir,USession::getBoolean('reverse-'.$activeDir));
		$chartType='ColumnChart';
		$tabs=$this->jquery->semantic()->htmlTab("tabs");
		$reverse=USession::get('reverse-'.$activeDir);
		foreach ($allResults as $title=>$result){
			$context = JString::cleanIdentifier($title);
			$dir=self::$outputDirectory.$activeDir.\DS.$title;

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
			$title=\str_replace(['-small','_small'],'<span class="ui mini olive circular label">S</span>',$title);
			$title=\str_replace(['-medium','_medium'],'<span class="ui mini yellow circular label">M</span>',$title);
			$title=\str_replace(['-large','_large'],'<span class="ui mini orange circular label">L</span>',$title);
			$content=$gui->replaceHtml($content);
			$tab=$tabs->addTab($title, $content);
		}
		$this->jquery->execAtLast(BuildResults::loadGoogleChart($chartType));

		$gui->frmFields($allElements);
		$gui->frmDatas($this->fw,$this->getAllTests($activeDir),$activeDir);
	}

	public function displayResults($dir){
		USession::set('activeDir',$dir);
		if(!URequest::isAjax()){
			$this->index();
			return ;
		}
		$this->results($dir);
		$this->jquery->renderView('Main/displayResults.html',['internal'=>true]);
	}

	public function getFolders(){
		$this->directories=\array_map('basename',\glob(self::$outputDirectory."/*",\GLOB_ONLYDIR));
	}

	public function getActiveDir(){
		$this->getFolders();
		return USession::get('activeDir',\current($this->directories));
	}

	public function getDatasArray($activeDir,?bool $reverse=false):array{
		$fws=USession::get("fws-".$activeDir,[]);
		$tests=USession::get('tests-'.$activeDir,[]);
		$filteredTests=USession::exists('tests-'.$activeDir);
		$dirs=glob(self::$outputDirectory.$activeDir."/*");
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
			$filtered=USession::exists('fws-'.$activeDir);
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
		if(USession::exists('fws-'.$activeDir)){
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
		$activeDir=$this->getActiveDir();
		$fwsToDisplay=UArray::iRemove(\explode(",", $_POST["fws"]), "");
		$testsToDisplay=UArray::iRemove(\explode(",", $_POST["tests"]), "");
		if(\count($fwsToDisplay)>0) {
			USession::set("fws-".$activeDir, $fwsToDisplay);
		}else{
			USession::delete("fws-".$activeDir);
		}
		if(\count($testsToDisplay)>0) {
			USession::set("tests-".$activeDir, $testsToDisplay);
		}else{
			USession::delete("tests-".$activeDir);
		}
		USession::set('reverse-'.$activeDir,isset($_POST['ck-reverse']));
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

	public static function getFwsToDisplay($activeDir){
		$fwsToDisplay=USession::get("fws-".$activeDir,[]);
		return \implode(",", $fwsToDisplay);
	}

	public static function getTestsToDisplay($activeDir){
		$testsToDisplay=USession::get("tests-".$activeDir,[]);
		return \implode(",", $testsToDisplay);
	}
	
	public function datas(){
		echo $this->gui->loadMdFile("datas", "datas.md");
	}
	
	public function doIt(){
		echo $this->gui->loadMdFile("doit", "doit.md");
	}

}