<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbMenuModel {
	private $_id = NULL;
	private $_name = NULL;
	private $_image = NULL;
	private $_detail = NULL;
	
	public function getId() {
		return $this->_id;
	}
	
	public function setId($id) {
		$this->_id = $id;
	}
		
	public function getName() {
		return $this->_name;
	}
	
	public function setName($name) {
		$this->_name = $name;
	}
	
	public function getImage() {
		return $this->_image;
	}
	
	public function setImage($image) {
		$this->_image = $image;
	}

	public function getDetail() {
		return $this->_detail;
	}
	
	public function setDetail($detail) {
		$this->_detail = $detail;
	}
	
}
