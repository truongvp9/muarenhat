<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbSliderManager extends CI_Model {
	private $_TABLE_NAME = 'mb_slider';
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
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE id_=".$model->getId();
		}
		else {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." ORDER BY order_";
		}
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	
	public function selectTop($model) {
		if ($model->getId()!=0) {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE id_=".$model->getId();
		}
		else {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." ORDER BY order_ LIMIT 6 ";
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
	 * delete a record in mb_type table
	 * 
	 * Enter description here ...
	 * @param unknown_type $model
	 */
	
	public function delete($model) {
		$this->db->where('id_', $model->getId());
		$this->db->delete($this->_TABLE_NAME);
	}
	
	/**
	 * generate insert (update) data object
	 * @param MbAdvManager $model
	 * array
	 */
	
	protected function getDataObject($model) {
		return array(
			//'id_' => $model->getId(),
			'img_' => $model->getImg(),
			'url_' => $model->getUrl(),
			'tooltip_' => $model->getToolTip(),
			'order_' => $model->getOrder(),
			'title_' => $model->getTitle()
		);
	}
	
	/**
	 * convert from Database Record to MbAdvManager
	 * @param record $record
	 * @return MbAdvManager
	 */
	
	protected function convert ($record) {
		$model = new MbSliderModel();
		$model->setId($record->id_);
		$model->setImg($record->img_);
		$model->setUrl($record->url_);
		$model->setToolTip($record->tooltip_);
		$model->setOrder($record->order_);
		$model->setTitle($record->title_);
		return $model;
	}	
}