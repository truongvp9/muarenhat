<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbSupportModel {
	private $_id = NULL;
	private $_name = NULL;
	private $_mobile = NULL;
	private $_yahoo = NULL;	
	
	public function setId($id){
		$this->_id=$id;
	}	
	
	public function getId(){
		return $this->_id;
	}
	
	public function setName($name){
		$this->_name=$name;
	}	
	
	public function getName(){
		return $this->_name;
	}
	
	public function setMobile($mobile){
		$this->_mobile=$mobile;
	}	
	
	public function getMobile(){
		return $this->_mobile;
	}	
	
	public function getYahoo(){
		return $this->_yahoo;
	}	

	public function setYahoo($yahoo){
		$this->_yahoo=$yahoo;
	}	
		
}