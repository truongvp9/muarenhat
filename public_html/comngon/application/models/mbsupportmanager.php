<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbSupportManager extends CI_Model {
	private $_TABLE_NAME = 'mb_support';
	function __construct()
	{
		parent::__construct();
	}
	
    /**
     * 
     * Enter description here ...
     * @param 
     */
	
	public function select($model) {
		if ($model->getId()!=0) {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE id=".$model->getId();
		}
		else {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." ORDER BY name";
		}
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	
	
	/**
	 * insert 
	 * 
	 * Enter description here ...
	 */
	
	public function insert($model) {
		$this->db->insert($this->_TABLE_NAME, $this->getDataObject($model));
		return $this->db->insert_id();
	}
	
	/**
	 * update 
	 * 
	 * Enter description here ...
	 */
	
	public function update($model) {
		$this->db->where("id",$model->getId());
		$this->db->update($this->_TABLE_NAME, $this->getDataObject($model));
	}
	
	/**
	 * delete a record in mb_type table
	 * 
	 * Enter description here ...
	 * @param unknown_type $model
	 */
	
	public function delete($model) {
		$this->db->where('id', $model->getId());
		$this->db->delete($this->_TABLE_NAME);
	}
	
	/**
	 * generate insert (update) data object
	 * @param MbSupportManager $model
	 * array
	 */
	
	protected function getDataObject($model) {
		return array(
			//'id_' => $model->getId(),
			'name' => $model->getName(),
			'mobile' => $model->getMobile(),
			'ym' => $model->getYahoo()
		);
	}
	
	/**
	 * convert from Database Record to MbAdvManager
	 * @param record $record
	 * @return MbSupportManager
	 */
	
	protected function convert($record) {
		$model = new MbSupportModel();
		$model->setId($record->id);
		$model->setName($record->name);
		$model->setMobile($record->mobile);
		$model->setYahoo($record->ym);
		return $model;
	}	
}