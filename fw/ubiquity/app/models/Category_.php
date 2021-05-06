<?php
namespace models;

use Ubiquity\attributes\items\Id;
use Ubiquity\attributes\items\Column;
use Ubiquity\attributes\items\Validator;
use Ubiquity\attributes\items\Table;
use Ubiquity\attributes\items\OneToMany;

#[Table(name: "category_")]
class Category_{
	
	#[Id()]
	#[Column(name: "id",dbType: "mediumint(8) unsigned")]
	#[Validator(type: "id",constraints: ["autoinc"=>true])]
	private $id;

	
	#[Column(name: "name",nullable: true,dbType: "varchar(255)")]
	#[Validator(type: "length",constraints: ["max"=>255])]
	private $name;

	
	#[OneToMany(mappedBy: "category_",className: "models\\User_")]
	private $user_s;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id=$id;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name=$name;
	}

	public function getUser_s(){
		return $this->user_s;
	}

	public function setUser_s($user_s){
		$this->user_s=$user_s;
	}

	 public function addUser_($user_){
		$this->user_s[]=$user_;
	}

	 public function __toString(){
		return $this->id.'';
	}

}