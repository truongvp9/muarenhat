<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbSliderModel {
	private $_id = NULL;
	private $_img = NULL;
	private $_url = NULL;
	private $_tooltip = NULL;	
	private $_order = NULL;
	private $_title = NULL;
	
	public function setId($id){
		$this->_id=$id;
	}	
	
	public function getId(){
		return $this->_id;
	}
	
	public function setImg($img){
		$this->_img=$img;
	}	
	
	public function getImg(){
		return $this->_img;
	}
	
	public function setUrl($url){
		$this->_url=$url;
	}	
	
	public function getUrl(){
		return $this->_url;
	}	

	public function setToolTip($tooltip){
		$this->_tooltip=$tooltip;
	}	
	
	public function getToolTip(){
		return $this->_tooltip;
	}

	public function setOrder($order){
		$this->_order=$order;
	}	
	
	public function getOrder(){
		return $this->_order;
	}
	
	public function setTitle($title){
		$this->_title=$title;
	}	
	
	public function getTitle(){
		return $this->_title;
	}	
		
}