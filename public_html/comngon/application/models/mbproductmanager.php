<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbProductManager extends CI_Model {
	private $_TABLE_NAME = 'mb_product';

	function __construct()
	{
		parent::__construct();
	}
	public function select($model) {
		return $this->_select($this->_TABLE_NAME, $model);
	}
	public function getTotalProduct($cat_id){
		$sql="SELECT count(*) as count FROM mb_product p join mb_category c on p.category_=c.id_ WHERE path_ like '%/".$cat_id."/%'";
		//die($sql);
		$query = $this->db->query($sql);
		$result = $query->result();
		//print_r($result); 
		return $result[0]->count;
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
		$this->db->order_by("date_","DESC");
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
		$this->db->where('id_', $model->getId());
		$this->db->update($table, $this->getDataObject2($model));
	}

	public function _delete($table, $model) {
		$this->db->where('id_', $orderModel->getId());
		$this->db->delete($table);
	}
	/**
	 * convert from Database Record to MbProductModel
	 * @param record $record
	 * @return MbProductModel
	 */
	public function convert ($record) {
		$model = new MbProductModel();
		$model->setId($record->id_);
		$model->setName($record->name_);
		$model->setPrice($record->price_);
		$model->setImagePath($record->image_path_);
		$model->setImageDefault($record->image_default_);
		$model->setImageThumbNail($record->image_thumbnail_);
		$model->setStatus($record->status_);
		$model->setDescription($record->description_);
		$model->setTechnicalDescription($record->technical_description_);
		$model->setCategory($record->category_);
		$model->setUserId($record->user_id_);
		$model->setPageView($record->page_view);
		return $model;
	}

	/**
	 * generate insert (update) data
	 * @param MbProductModel $model
	 * array
	 */
	protected function getDataObject($model) {
		return array(
		    //'id_' => $model->getId(),
			'name_' => $model->getName(),
			'price_' => $model->getPrice(),
			'image_path_' => $model->getImagePath(),
			'image_default_' => $model->getImageDefault(),
			'status_' => $model->getStatus(),
			'description_' => $model->getDescription(),
			'technical_description_' => $model->getTechnicalDescription(),
			'category_' => $model->getCategory(),
			'image_thumbnail_' => $model->getImageThumbNail(),
			'user_id_' => $model->getUserId(),
			'date_' => $model->getDate(),
			'page_view' => $model->getPageView(),
			'store_cat_id' => $model->getStoreCatId()
		);
	}
	
	protected function getDataObject2($model) {
		return array(
		    //'id_' => $model->getId(),
			'name_' => $model->getName(),
			'price_' => $model->getPrice(),
			//'image_path_' => $model->getImagePath(),
			'image_default_' => $model->getImageDefault(),
			'status_' => $model->getStatus(),
			'description_' => $model->getDescription(),
			'technical_description_' => $model->getTechnicalDescription(),
			'category_' => $model->getCategory(),
			'image_thumbnail_' => $model->getImageThumbNail(),
			'user_id_' => $model->getUserId(),
			'date_' => $model->getDate(),
			//'page_view' => $model->getPageView(),
			'store_cat_id' => $model->getStoreCatId()
		);
	}

	/**
	 * generate where condition
	 * @param MbProductModel $model
	 * array
	 */
	protected function getWhereObject($model) {
		$whereCondition = array();
		if (!is_null($model->getId())) {
			$whereCondition['id_'] = $model->getId();
		}
		if (!is_null($model->getName())) {
			//$whereCondition['name_'] = $model->getName();
			$this->db->like('name_',$model->getName());
		}
		if (!is_null($model->getPrice())) {
			$whereCondition['price_'] = $model->getPrice();
		}
		if (!is_null($model->getImagePath())) {
			$whereCondition['image_path_'] = $model->getImagePath();
		}
		if (!is_null($model->getImageDefault())) {
			$whereCondition['image_default_'] = $model->getImageDefault();
		}
		if (!is_null($model->getStatus())) {
			$whereCondition['status_'] = $model->getStatus();
		}
		if (!is_null($model->getDescription())) {
			$whereCondition['description_'] = $model->getDescription();
		}
		if (!is_null($model->getTechnicalDescription())) {
			$whereCondition['technical_description_'] = $model->getTechnicalDescription();
		}
		if (!is_null($model->getCategory())) {
			$whereCondition['category_'] = $model->getCategory();
		}
		if (!is_null($model->getUserId())) {
			$whereCondition['user_id_'] = $model->getUserId();
		}
		if (!is_null($model->getStoreCatId())) {
			$whereCondition['store_cat_id'] = $model->getStoreCatId();
		}		
		return $whereCondition;
	}
	
	/**
	 *  select all product in root category
	 * 
	 */
	
	public function selectByRootCategory($cid,$limit,$offset) {
		$this->load->database();
		$sql = "SELECT user_id_,p.id_,p.name_,p.price_,p.image_default_,image_path_,description_,image_thumbnail_,technical_description_,category_,status_,page_view FROM mb_product p join mb_category c ON c.id_=p.category_ WHERE c.id_= '".$cid."' ORDER BY p.date_ DESC LIMIT $limit OFFSET $offset";
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;
	}
}

?>