<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbContentModel {
	private $_id = NULL;
	private $_title = NULL;
	private $_content = NULL;
	private $_date = NULL;
	private $_cat = NULL;
	
	public function setId($id){
		$this->_id=$id;
	}	
	
	public function getId(){
		return $this->_id;
	}
	
	public function setTitle($title){
		$this->_title=$title;
	}	
	
	public function getTitle(){
		return $this->_title;
	}
	
	public function setContent($content){
		$this->_content=$content;
	}	
	
	public function getContent(){
		return $this->_content;
	}

	public function setDate($date){
		$this->_date=$date;
	}	
	
	public function getDate(){
		return $this->_date;
	}
			
	public function setCat($cat){
		$this->_cat=$cat;
	}	
	
	public function getCat(){
		return $this->_cat;
	}
}
