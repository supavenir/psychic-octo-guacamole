<?php
namespace models;

use Ubiquity\attributes\items\Id;
use Ubiquity\attributes\items\Column;
use Ubiquity\attributes\items\Validator;
use Ubiquity\attributes\items\Table;
use Ubiquity\attributes\items\ManyToOne;
use Ubiquity\attributes\items\JoinColumn;

#[Table(name: "user_")]
class User_{
	
	#[Id()]
	#[Column(name: "id",dbType: "mediumint(8) unsigned")]
	#[Validator(type: "id",constraints: ["autoinc"=>true])]
	private $id;

	
	#[Column(name: "firstname",nullable: true,dbType: "varchar(255)")]
	#[Validator(type: "length",constraints: ["max"=>255])]
	private $firstname;

	
	#[Column(name: "lastname",nullable: true,dbType: "varchar(255)")]
	#[Validator(type: "length",constraints: ["max"=>255])]
	private $lastname;

	
	#[Column(name: "age",nullable: true,dbType: "mediumint(9)")]
	private $age;

	
	#[Column(name: "sexe",nullable: true,dbType: "varchar(255)")]
	#[Validator(type: "length",constraints: ["max"=>255])]
	private $sexe;

	
	#[Column(name: "city",nullable: true,dbType: "varchar(255)")]
	#[Validator(type: "length",constraints: ["max"=>255])]
	private $city;

	
	#[ManyToOne()]
	#[JoinColumn(className: "models\\Category_",name: "idCategory",nullable: true)]
	private $category_;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id=$id;
	}

	public function getFirstname(){
		return $this->firstname;
	}

	public function setFirstname($firstname){
		$this->firstname=$firstname;
	}

	public function getLastname(){
		return $this->lastname;
	}

	public function setLastname($lastname){
		$this->lastname=$lastname;
	}

	public function getAge(){
		return $this->age;
	}

	public function setAge($age){
		$this->age=$age;
	}

	public function getSexe(){
		return $this->sexe;
	}

	public function setSexe($sexe){
		$this->sexe=$sexe;
	}

	public function getCity(){
		return $this->city;
	}

	public function setCity($city){
		$this->city=$city;
	}

	public function getCategory_(){
		return $this->category_;
	}

	public function setCategory_($category_){
		$this->category_=$category_;
	}

	 public function __toString(){
		return $this->id.'';
	}

}