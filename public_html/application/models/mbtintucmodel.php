<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbTinTucModel {
	private $_id = NULL;
	private $_title = NULL;
	private $_url = NULL;
	private $_summary = NULL;
	private $_detail = NULL;
	private $_date = NULL;
	private $_priority = NULL;
	private $_img = NULL;
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
	
	public function setUrl($url){
		$this->_url=$url;
	}	
	
	public function getUrl(){
		return $this->_url;
	}	

	public function setSummary($summary){
		$this->_summary=$summary;
	}	
	
	public function getSummary(){
		return $this->_summary;
	}

	public function setDetail($detail){
		$this->_detail=$detail;
	}	
	
	public function getDetail(){
		return $this->_detail;
	}

	public function setDate($date){
		$this->_date=$date;
	}	
	
	public function getDate(){
		return $this->_date;
	}
	
	public function setPriority($priority){
		$this->_priority=$priority;
	}	
	
	public function getPriority(){
		return $this->_priority;
	}
	
	public function setImg($img){
		$this->_img=$img;
	}	
	
	public function getImg(){
		return $this->_img;
	}
		
	public function setCat($cat){
		$this->_cat=$cat;
	}	
	
	public function getCat(){
		return $this->_cat;
	}
}


