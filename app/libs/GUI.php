<?php

namespace libs;

use Ajax\Semantic;
use Ubiquity\utils\base\UFileSystem;
use controllers\Main;
use Ajax\semantic\html\elements\HtmlButton;

class GUI {
	/**
	 * @var Semantic
	 */
	private $semantic;
	
	private static $mdDirectory=ROOT."/../public/";
	
	public function __construct(Semantic $semantic){
		$this->semantic=$semantic;
	}
	
	public function createInternalMenu($context,$items){
		$menu=$this->semantic->htmlMenu("nav-".$context);
		foreach ($items as $elm){
			$item=$menu->addItem($elm);
			$item->asLink("#{$context}-{$elm}")->addToProperty("class","_field ".$elm);
			if(!Main::displayField($elm)){
				$item->addToProperty("style","display:none;");;
			}
		}
		$menu->setActiveItem(0);
		$bt=new HtmlButton("bt-display-fields-".$context,"Select fields...","select-fields");
		$menu->addItem($bt);
		$menu->setSecondary();
		return $menu;
	}
	
	public function getUrls($url_file){
		if(file_exists($url_file)){
			$header=$this->semantic->htmlHeader("url-header","3","You can test yourself the urls below:");
			$list=$this->semantic->htmlList("list-urls");
			$urls = file($url_file);
			foreach ($urls as $url) {
				$parts = parse_url(trim($url));
				$url = $parts['scheme'] . '://' . $_SERVER['HTTP_HOST'] .$parts['path'];
				if (isset($parts['query'])) {
					$url .= '?' . $parts['query'];
				}
				$url=htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
				$item=$list->addItem($url);
				$item->asLink($url,"_new");
			}
			return $header.$list;
		}
		return false;
	}
	
	public function displayIniFile(&$title,$id,$filename,$icon,$type=""){
		if(file_exists($filename)){
			$iniContent=parse_ini_file($filename,true);
			$configMessage=$this->semantic->htmlMessage($id,"",$type);
			$content="";
			if(isset($iniContent["test"])){
				if(isset($iniContent["test"]["title"])){
					$title=$iniContent["test"]["title"];
				}
				unset($iniContent["test"]);
			}
			foreach ($iniContent as $section=>$elements){
				$content.="<div class='header'>{$section}</div>";
				$content.="<ul>";
				foreach ($elements as $k=>$v){
					$content.="<li><b>{$k}</b> : {$v}</li>";
				}
				$content.="</ul>";
			}
			$configMessage->setContent($content);
			$configMessage->setIcon($icon);
			return $configMessage;
		}
		return "";
	}
	
	public function loadMdFile($id,$filename){
		$filename=self::$mdDirectory.$filename;
		if(file_exists($filename)){
			$fileContent=UFileSystem::load($filename);
			$pd=new \Parsedown();
			$segment=$this->semantic->htmlSegment($id,$pd->text($fileContent));
			return $segment;
		}
		return "";
	}
	
	public function replaceHtml($content){
		return preg_replace("@\{icon\:(.*?)\}@", "<i class='ui $1 icon'></i>",$content);
	}
	
	public function frmFields($elements){
		$items=array_combine($elements, $elements);
		$form=$this->semantic->htmlForm("frm-fields");
		$fields=$form->addFields();
		$dd=$fields->addDropdown("fields",$items,null,Main::getFieldsToDisplay(),true);
		$dd->getField()->setDefaultText("Select fields to display...");
		$bt=$fields->addButton("bt-validate-fields", "Valider");
		$form->submitOnClick($bt, "Main/filterFields", "#div-fields-response",["hasLoader"=>"internal"]);
	}
}

