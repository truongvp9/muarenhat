<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbCategoryModel {
	private $_id = NULL;
	private $_parent_id = NULL;
	private $_name = NULL;
	private $_order = NULL;
	private $_path = NULL;
	private $_visible = NULL;
	private $_priority = NULL;
	private $_home = NULL;
	
	public function getId() {
		return $this->_id;
	}
	
	public function setId($id) {
		$this->_id = $id;
	}
	
	public function getVisible() {
		return $this->_visible;
	}
	
	public function setVisible($visible) {
		$this->_visible = $visible;
	}
	
	public function getPath() {
		return $this->_path;
	}
	
	public function setPath($path) {
		$this->_path = $path;
	}
	
	public function getName() {
		return $this->_name;
	}
	
	public function setName($name) {
		$this->_name = $name;
	}

	public function getParentId() {
		return $this->_parent_id;
	}
	
	public function setParentId($_parent_id) {
		$this->_parent_id = $_parent_id;
	}

	public function getOrder() {
		return $this->_order;
	}

	public function setOrder($order) {
		$this->_order = $order;
	}
	
	public function getPriority() {
		return $this->_priority;
	}

	public function setPriority($priority) {
		$this->_priority = $priority;
	}
	
	public function getHome() {
		return $this->_home;
	}

	public function setHome($home) {
		$this->_home = $home;
	}	
}