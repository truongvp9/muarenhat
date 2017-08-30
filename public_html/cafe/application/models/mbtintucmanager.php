<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbTinTucManager extends CI_Model {
	private $_TABLE_NAME = 'mb_news';
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
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE id_=".$model->getId()." ORDER BY date_ DESC LIMIT 100";
		}
		else
		if ($model->getCat()!=0) {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE cat_=".$model->getCat()." ORDER BY date_ DESC LIMIT 100";
		}
		else {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." ORDER BY date_ DESC LIMIT 100";
		}
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	
	public function selectByPage($model,$limit,$offset) {
		if ($model->getId()!=0) {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE id_=".$model->getId()." ORDER BY date_ DESC LIMIT $limit OFFSET $offset";
		}
		else
		if ($model->getCat()!=0) {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE cat_=".$model->getCat()." ORDER BY date_ DESC LIMIT $limit OFFSET $offset";
		}
		else {
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." ORDER BY date_ DESC LIMIT $limit OFFSET $offset";
		}
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	
	public function select_top() {
		$sql = "SELECT * FROM ".$this->_TABLE_NAME." ORDER BY date_ DESC LIMIT 5";
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	
	public function select_top_hot() {
		$sql = "SELECT * FROM ".$this->_TABLE_NAME." ORDER BY date_ DESC LIMIT 2";
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
	 * delete a record in mb_news table
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
	 * @param MbTinTucManager $model
	 * array
	 */
	
	protected function getDataObject($model) {
		return array(
			//'id_' => $model->getId(),
			'title_' => $model->getTitle(),
			'url_' => $model->getUrl(),
			'summary_' => $model->getSummary(),
			'detail_' => $model->getDetail(),
			'priority' => $model->getPriority(),
			'date_' => $model->getDate(),
			'img_' => $model->getImg(),
			'cat_' => $model->getCat()
		);
	}
	
	/**
	 * convert from Database Record to MbTinTucManager
	 * @param record $record
	 * @return MbTinTucManager
	 */
	
	protected function convert ($record) {
		$model = new MbTinTucModel();
		$model->setId($record->id_);
		$model->setTitle($record->title_);
		$model->setUrl($record->url_);
		$model->setSummary($record->summary_);
		$model->setDetail($record->detail_);
		$model->setPriority($record->priority);
		$model->setDate($record->date_);
		$model->setImg($record->img_);
		$model->setCat($record->cat_);
		return $model;
	}	
}