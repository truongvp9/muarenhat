<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbMenuManager extends CI_Model {

	private $_TABLE_NAME = 'mb_menu';

	function __construct()
	{
		parent::__construct();
	}
	public function select($model) {
		return $this->_select($this->_TABLE_NAME, $model);
	}
	public function insert($model) {
		return $this->_insert($this->_TABLE_NAME, $model);
	}
	public function update($model) {
		return $this->_update($this->_TABLE_NAME, $model);
	}
	public function delete($model) {
		return $this->_delete($this->_TABLE_NAME, $model);
	}
	
	public function _insert($table, $model) {
		$this->db->insert($table, $this->getDataObject($model));
		return $this->db->insert_id();
	}

	public function _update($table, $model) {
		$this->db->where('id_', $model->getId());
		$this->db->update($table, $this->getDataObject($model));
	}	
	
	public function _delete($table, $model) {
		$this->db->where('id_', $model->getId());
		$this->db->delete($table);
	}
	
	public function _select($table, $model) {
		$whereCondition = $this->getWhereObject($model);
		$query = $this->db->get_where($table, $whereCondition);		
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}	
	
	/**
	 * generate insert (update) data object
	 * @param MbMenuModel $model
	 * array
	 */
	protected function getDataObject($model) {
		return array(
			'name_' => $model->getName(),
			'image_' => $model->getImage(),
			'detail_' => $model->getDetail()
		);
	}	
	
	/**
	 * convert from Database Record to MbMenuModel
	 * @param record $record
	 * @return MbMenuModel
	 */
	protected function convert ($record) {
		$model = new MbMenuModel();
		$model->setId($record->id_);
		$model->setName($record->name_);
		$model->setImage($record->image_);
		$model->setDetail($record->detail_);
		return $model;
	}

	/**
	 * generate where condition
	 * @param MbCategoryModel $model
	 * array
	 */
	protected function getWhereObject($model) {
		$whereCondition = array();
		if (!is_null($model->getId())) {
			$whereCondition['id_'] = $model->getId();
		}
		if (!is_null($model->getName())) {
			$whereCondition['name_'] = $model->getName();
		}
		if (!is_null($model->getImage())) {
			$whereCondition['image_'] = $model->getImage();
		}
		if (!is_null($model->getDetail())) {
			$whereCondition['detail_'] = $model->getDetail();
		}		
		return $whereCondition;
	}	

}