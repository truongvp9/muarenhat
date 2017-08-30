<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbSeoManager extends CI_Model {
	private $_TABLE_NAME = 'mb_seo';

	function __construct()
	{
		parent::__construct();
	}
	
	public function _select($url) {
		$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE url_='".$url."'";
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		if (count($modelArray)>0) {
			return $modelArray[0];
		}
		else {
			return new MbSeoModel();
		}
	}
	
	public function _insert($model) {
		$this->_delete($model);
		$data = array(
			'url_' => $model->getUrl(),
			'title_' => $model->getTitle(),
			'description_' => $model->getDescription(),
			'keyword_' => $model->getKeyWord(),
		);
		$this->db->insert($this->_TABLE_NAME, $data); 
	}
	
	public function _update(){
		
	}
	
	public function _delete($model) {
		$this->db->where('url_', $model->getUrl());
		$this->db->delete($this->_TABLE_NAME);
	}
	
	/**
	 * Convert record to model
	 * @param $record
	 */
	
	protected function convert ($record) {
		$model = new MbSeoModel();
		$model->setUrl($record->url_);
		$model->setTitle($record->title_);
		$model->setDescription($record->description_);
		$model->setKeyWord($record->keyword_);
		return $model;
	}
}