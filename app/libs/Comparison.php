<?php

namespace libs;

class Comparison {
	private $id;
	private $cases;
	private $frameworks;
	
	public function __construct($id,$cases,$frameworks){
		$this->id=$id;
		$this->cases=$cases;
		$this->frameworks=$frameworks;
	}


	/**
	 * @return mixed
	 */
	public function getCases() {
		return $this->cases;
	}

	/**
	 * @return mixed
	 */
	public function getFrameworks() {
		return $this->frameworks;
	}

	/**
	 * @param mixed $cases
	 */
	public function setCases($cases) {
		$this->cases = $cases;
	}

	/**
	 * @param mixed $frameworks
	 */
	public function setFrameworks($frameworks) {
		$this->frameworks = $frameworks;
	}
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id) {
		$this->id = $id;
	}


	
}

