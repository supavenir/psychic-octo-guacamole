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
	
	public function initialize(){
		parent::initialize();
		$this->gui=new GUI($this->jquery->semantic());
	}

	public function index(){
		$gui=$this->gui;
		$allElements=[];
		$allResults=[];
		$chartType='ColumnChart';
		$tabs=$this->jquery->semantic()->htmlTab("tabs");
		$dirs=glob(self::$outputDirectory."public/*");
		foreach ($dirs as $dir){
			if(is_dir($dir)){
				$title=basename($dir);
				$context=JString::cleanIdentifier($title);
				$file=$dir.DS.self::$resultFile;
				if(file_exists($file)){
					$result=BuildResults::parseResults($file);
					$allResults[$title]=$result;
					$elements=BuildResults::makeAllGraphs(function($id) use ($result){
						$data = array();
						$data[] = array('', $id, array('role' => 'style'));  // header
						
						foreach ($result as $fw => $res) {
							$data[] = array($fw, $res[$id], BuildResults::getBarColor($fw));
						}
						return $data;
					}, $context,$chartType);
					$kElements=array_keys($elements);
					$allElements=array_merge($allElements, $kElements);
					$content=$gui->createInternalMenu($context, $kElements);
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
			}
		}
		if(($urls=$gui->getUrls(self::$outputDirectory."urls.log"))!==false){
			$urls="<div class='ui segment'>".$urls."</div>";
		}
		
		$gui->displayIniFile($title,"server-config",self::$outputDirectory."configuration.ini","");
		$gui->frmFields($allElements);
		$this->jquery->execAtLast(BuildResults::loadGoogleChart($chartType));
		$this->jquery->click(".select-fields","$('#div-fields').toggle();");
		$this->jquery->getHref("a[data-target]","",["ajaxTransition"=>"random"]);
		$this->jquery->renderDefaultView(["urls"=>$urls]);
	}
	
	public function filterFields(){
		$fieldsToDisplay=explode(",", $_POST["fields"]);
		$fieldsToDisplay=UArray::iRemove($fieldsToDisplay, "");
		USession::set("fields", $fieldsToDisplay);
		if(sizeof($fieldsToDisplay)===0){
			$this->jquery->execAtLast('$("._field").show();');
		}else{
			$selectors=array_map(function($elm){return ".".$elm;}, $fieldsToDisplay);
			$this->jquery->execAtLast('$("._field").hide();$("'.implode(", ",$selectors).'").show();');
			
		}
		$this->jquery->execAtLast("$('#div-fields').hide();");
		echo $this->jquery->compile();
	}
	
	public static function displayField($elementId){
		$fieldsToDisplay=USession::get("fields",[]);
		if(sizeof($fieldsToDisplay)===0){
			return true;
		}
		return array_search($elementId, $fieldsToDisplay)!==false;
	}
	
	public static function getFieldsToDisplay(){
		$fieldsToDisplay=USession::get("fields",[]);
		return implode(",", $fieldsToDisplay);
	}
	
	public function datas(){	
		echo $this->gui->loadMdFile("datas", "datas.md");
	}
	
	public function doIt(){
		echo $this->gui->loadMdFile("doit", "doit.md");
	}

}