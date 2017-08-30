<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbSeoModel {
	private $_url = NULL;
	private $_title = NULL;
	private $_description = NULL;
	private $_keyword = NULL;

	public function setUrl($url){
		$this->_url=$url;
	}
	
	public function getUrl(){
		return $this->_url;
	}	
		
	public function setTitle($title){
		$this->_title=$title;
	}
	
	public function getTitle(){
		return $this->_title;
	}	
	
	public function setDescription($description){
		$this->_description=$description;
	}
	
	public function getDescription(){
		return $this->_description;
	}	
	
	public function setKeyword($keyword){
		$this->_keyword=$keyword;
	}
	
	public function getKeyword(){
		return $this->_keyword;
	}	

	public function SEO($url='') {
		return $this;
	}
	
}
