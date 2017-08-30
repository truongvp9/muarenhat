<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbContentManager extends CI_Model {
	private $_TABLE_NAME = 'mb_content';
	function __construct()
	{
		parent::__construct();
	}
	// select
	public function select($model) {
		if ($model->getId()!=0) {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE id_=".$model->getId();
		}
		else {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." ORDER BY date_";
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
		$this->db->where("id_",$model->getId());
		$this->db->update($this->_TABLE_NAME, $this->getDataObject($model));
	}

	/**
	 * delete a record in mb_content table
	 * 
	 * Enter description here ...
	 * @param unknown_type $model
	 */
	
	public function delete($model) {
		$this->db->where('id_', $model->getId());
		$this->db->delete($this->_TABLE_NAME);
	}
	
protected function getDataObject($model) {
		return array(
			//'id_' => $model->getId(),
			'title_' => $model->getTitle(),
			'content_' => $model->getContent(),
			'date_' => $model->getDate(),
			'cat_' => $model->getCat()
		);
	}
	
	/**
	 * convert from Database Record to MbTinTucManager
	 * @param record $record
	 * @return MbTinTucManager
	 */
	
	protected function convert ($record) {
		$model = new MbContentModel();
		$model->setId($record->id_);
		$model->setTitle($record->title_);
		$model->setContent($record->content_);
		$model->setDate($record->date_);
		$model->setCat($record->cat_);
		return $model;
	}		
}