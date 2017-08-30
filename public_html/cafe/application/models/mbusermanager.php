<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbUserManager extends CI_Model {
	private $_TABLE_NAME = 'mb_user';

	function __construct()
	{
		parent::__construct();
		// $this->load->database();
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
	/*public function delete($model) {
		return $this->_delete($this->_TABLE_NAME, $model);
	}*/
	public function selectStore() {
		$sql = "SELECT distinct * FROM mb_user u inner join mb_store s on (u.id_=s.owner_ AND u.active_=1)";
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;		
	}
	public function selectStoreByPage($limit,$offset) {
		$sql = "SELECT distinct s.id_ as store_id_,s.skin_,s.cid_,u.id_,u.name_,u.account_,u.email_,u.phone_,u.fax_,u.mobile_,u.address_,u.ym_,u.skype_,u.active_,u.type_,u.website_,u.password_ FROM mb_user u inner join mb_store s on (u.id_=s.owner_ AND u.active_=1) ORDER BY u.id_ DESC LIMIT $limit OFFSET $offset";
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert2($value);
		}
		return $modelArray;		
	}
	public function selectStoreCat($cid) {
		$sql = "SELECT distinct * FROM mb_user u inner join mb_store s on (u.id_=s.owner_ AND u.active_=1) WHERE cid_=$cid";
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert($value);
		}
		return $modelArray;		
	}	
	public function selectStoreCatByPage($cid,$limit,$offset) {
		$sql = "SELECT distinct s.id_ as store_id_,s.skin_,s.cid_,u.id_,u.name_,u.account_,u.email_,u.phone_,u.fax_,u.mobile_,u.address_,u.ym_,u.skype_,u.active_,u.type_,u.website_,u.password_ FROM mb_user u inner join mb_store s on (u.id_=s.owner_ AND u.active_=1) WHERE s.cid_=$cid ORDER BY u.id_ DESC LIMIT $limit OFFSET $offset";
		$query = $this->db->query($sql);
		$dataResult = $query->result();
		$modelArray = array();
		foreach ($dataResult as $key => $value) {
			$modelArray[] = $this->convert2($value);
		}
		return $modelArray;		
	}	
	public function _select($table, $model) {
		$whereCondition = $this->getWhereObject($model);
		$query = $this->db->get_where($table, $whereCondition);
		$this->db->order_by("id_","desc");
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
		$this->db->where('account_', $model->getAccount());
		$this->db->update($table, $this->getDataObject2($model));
	}
	public function setactive($id,$value) {
		$sql = "UPDATE mb_user SET active_=$value WHERE id_=".$id;
		$this->db->query($sql);
	}
	/*public function _delete($table, $model) {
		$this->db->where('id_', $orderModel->getId());
		$this->db->delete($table);
	}*/
	/**
	 * convert from Database Record to MbUserModel
	 * @param record $record
	 * @return MbUserModel
	 */
	protected function convert ($record) {
		$model = new MbUserModel();
		$model->setId($record->id_);
		$model->setAccount($record->account_);
		$model->setPassword($record->password_);
		$model->setName($record->name_);
		$model->setAddress($record->address_);
		$model->setEmail($record->email_);
		$model->setPhone($record->phone_);
		$model->setFax($record->fax_);
		$model->setYM($record->ym_);
		$model->setSkype($record->skype_);
		$model->setType($record->type_);
		$model->setMobile($record->mobile_);
		$model->setWebsite($record->website_);
		$model->setActive($record->active_);
		return $model;
	}

	protected function convert2 ($record) {
		$model = new MbUserModel();
		$model->setId($record->id_);
		$model->setAccount($record->account_);
		$model->setPassword($record->password_);
		$model->setName($record->name_);
		$model->setAddress($record->address_);
		$model->setEmail($record->email_);
		$model->setPhone($record->phone_);
		$model->setFax($record->fax_);
		$model->setYM($record->ym_);
		$model->setSkype($record->skype_);
		$model->setType($record->type_);
		$model->setMobile($record->mobile_);
		$model->setWebsite($record->website_);
		$model->setActive($record->active_);
		$model->setStoreId($record->store_id_);
		$model->setSkin($record->skin_);
		$model->setCatId($record->cid_);
		return $model;
	}

	/**
	 * generate insert (update) data
	 * @param MbUserModel $model
	 * array
	 */
	protected function getDataObject($model) {
		return array(
			'account_' => $model->getAccount(),
			'password_' => $model->getPassword(),
			'name_' => $model->getName(),
			'address_' => $model->getAddress(),
		    'email_' => $model->getEmail(),
			'phone_' => $model->getPhone(),
			'fax_' => $model->getFax(),
			'ym_' => $model->getYM(),
			'skype_' => $model->getSkype(),
			'type_' => $model->getType(),
			'mobile_' => $model->getMobile(),
			'website_' => $model->getWebsite(),
		    'active_' => $model->getActive()			
		);
	}
	
	/**
	 * generate insert (update) data
	 * @param MbUserModel $model
	 * array
	 */
	protected function getDataObject2($model) {
		return array(
			'name_' => $model->getName(),
			'address_' => $model->getAddress(),
		    'email_' => $model->getEmail(),
			'phone_' => $model->getPhone(),
			'fax_' => $model->getFax(),
			'ym_' => $model->getYM(),
			'skype_' => $model->getSkype(),
			'type_' => $model->getType(),
			'mobile_' => $model->getMobile(),
			'website_' => $model->getWebsite(),
			'active_' => $model->getActive(),
			'province_' => $model->getProvince()
		);
	}

	/**
	 * generate where condition
	 * @param MbUserModel $model
	 * array
	 */
	protected function getWhereObject($model) {
		$whereCondition = array();
		if (!is_null($model->getId())) {
			$whereCondition['id_'] = $model->getId();
		}
		if (!is_null($model->getAccount())) {
			$whereCondition['account_'] = $model->getAccount();
		}
		if (!is_null($model->getPassword())) {
			$whereCondition['password_'] = $model->getPassword();
		}
		if (!is_null($model->getName())) {
			$whereCondition['name_'] = $model->getName();
		}
		if (!is_null($model->getEmail())) {
			$whereCondition['email_'] = $model->getEmail();
		}
		if (!is_null($model->getPhone())) {
			$whereCondition['phone_'] = $model->getPhone();
		}
		if (!is_null($model->getFax())) {
			$whereCondition['fax_'] = $model->getFax();
		}
		if (!is_null($model->getType())) {
			$whereCondition['type_'] = $model->getType();
		}
		return $whereCondition;
	}
	
	
	/**
	 * 
	 * send email
	 * Enter description here ...
	 * @param unknown_type $email
	 */
	
	public function sendEmail($email,$subject,$message) {
			// $to      = 'truongnm82@gmail.com';

			$this->email->from('webmaster@muaban12.net', 'Mua ban 12 Admin');
			
			$this->email->to($email);

			$this->email->subject($subject);
			
			$this->email->message($message);

			$this->email->send();
	}
	
	public function authenticate($userModel) {
		//$this->load->database();
		$sql = "SELECT * FROM ".$this->_TABLE_NAME." WHERE account_='".$userModel->getAccount()."' AND password_='".$userModel->getPassword()."'";
		// die($sql);
		$result = $this->db->query($sql);
		return $result->num_rows();
	}	
	
    function getUsername() {
            
            $this->load->library('session');   
        
            return $this->session->userdata('username');
            
    }
        
    // login successfully 
    function isLogin () {
            
            $this->load->library('session');   
        
            return $this->session->userdata('logged_in');
            
    }	
	
}

?>