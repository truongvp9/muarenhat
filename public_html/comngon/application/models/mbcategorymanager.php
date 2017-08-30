<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbCategoryManager extends CI_Model {

	private $_TABLE_NAME = 'mb_category';

	function __construct()
	{
		parent::__construct();
	}
	public function select($model) {
		return $this->_select($this->_TABLE_NAME, $model);
	}
	public function selectByPage($model, $limit, $offset) {
		return $this->_selectByPage($this->_TABLE_NAME, $model, $limit, $offset);
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
	
	public function selectHome($model) {
		$sql = "SELECT * FROM mb_category WHERE home_=1 ORDER BY priority";
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;		
	}
	
	public function _select($table, $model) {
		$whereCondition = $this->getWhereObject($model);
		if ($model->getVisible()==1) {
			$this->db->order_by("priority");
		}
		else {
			$this->db->order_by("order_");
		}
		$query = $this->db->get_where($table, $whereCondition);		
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	
	public function _selectByOrder($model) {
		$whereCondition = $this->getWhereObject($model);
		$this->db->order_by("order_");
		$query = $this->db->get_where($this->_TABLE_NAME, $whereCondition);		
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	
	public function _selectByPriority($model) {
		$whereCondition = $this->getWhereObject($model);
		$this->db->order_by("priority");
		$query = $this->db->get_where($this->_TABLE_NAME, $whereCondition);		
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}

	public function _selectByPage($table, $model, $limit, $offset) {
		$whereCondition = $this->getWhereObject($model);
		$query = $this->db->get_where($table, $whereCondition, $limit, $offset);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	
	public function selectBreadcrumb($cat_id) {
		$sql = "SELECT c.id_ c_id_,c.name_ c_name_,p.id_ p_id_,p.name_ p_name_,r.id_ r_id_,r.name_ r_name_ FROM mb_category c left join mb_category p on (c.parent_id_=p.id_) left join mb_category r on (p.parent_id_=r.id_) WHERE c.id_=".$cat_id;
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		return $dataResult;
	}

	public function _insert($table, $model) {
		$this->db->insert($table, $this->getDataObject($model));
		return $this->db->insert_id();
	}

	public function _update($table, $model) {
		$this->db->where('id_', $model->getId());
		$this->db->update($table, $this->getDataObject($model));
	}
	
	public function updateOrder($id,$order) {
		$this->db->where('id_', $id);
		$this->db->update($this->_TABLE_NAME,array("order_"=>$order));
	}
	
	public function updatePriority($id,$priority) {
		$this->db->where('id_', $id);
		$this->db->update($this->_TABLE_NAME,array("priority"=>$priority));
	}
	
	public function visible($id,$visible) {
		$this->db->where('id_', $id);
		$this->db->update($this->_TABLE_NAME,array("visible_"=>$visible));
	}

	public function _delete($table, $model) {
		$this->db->where('id_', $model->getId());
		$this->db->delete($table);
	}
	/**
	 * convert from Database Record to MbCategoryModel
	 * @param record $record
	 * @return MbCategoryModel
	 */
	protected function convert ($record) {
		$model = new MbCategoryModel();
		$model->setName($record->name_);
		$model->setId($record->id_);
		$model->setParentId($record->parent_id_);
		$model->setOrder($record->order_);
		$model->setVisible($record->visible_);
		$model->setPath($record->path_);
		$model->setPriority($record->priority);
		$model->setHome($record->home_);
		return $model;
	}

	/**
	 * generate insert (update) data object
	 * @param MbCategoryModel $model
	 * array
	 */
	protected function getDataObject($model) {
		return array(
			'name_' => $model->getName(),
			'parent_id_' => $model->getParentId(),
			'order_' => $model->getOrder(),
			'visible_' => $model->getVisible(),
			'path_' => $model->getPath(),
			'priority' => $model->getPriority()
		);
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
		if (!is_null($model->getParentId())) {
			$whereCondition['parent_id_'] = $model->getParentId();
		}
		if (!is_null($model->getVisible())) {
			$whereCondition['visible_'] = $model->getVisible();
		}
		if (!is_null($model->getPath())) {
			$whereCondition['path_'] = $model->getPath();
		}
		return $whereCondition;
	}
}

?>