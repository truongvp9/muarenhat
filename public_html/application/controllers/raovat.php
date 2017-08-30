<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Raovat extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	/**
	 *  listing cac chu de rao vat
	 * 
	 */
	
	public function index()
	{  
		// $this->load->database(); // connect to db
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbtypemanager');
		$this->load->model('mbneedmanager');
		$this->load->model('mbtypemodel');
		$this->load->model('mbneedmodel');
		$this->load->model('mbadvmanager');	
		$this->load->model('mbadvmodel');					
		// new category model
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();		
		$typeManager = new MbTypeManager();
		$needManager = new MbNeedManager();
		$categoryModel->setParentId(0);
		$data['category'] = $categoryManager->_selectByOrder($categoryModel);	
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			$data['type'][$value->getId()] = $typeManager->select($cat_id);	
		}
		
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			// $categoryModel->setParentId($cat_id);
			$data['need'][$value->getId()] = $needManager->select($cat_id);	
		}	
		$advModel = new MbAdvModel();
		$advManager = new MbAdvManager();
		$this->loadHeader();
		//$advModel->setRaovat(1);
		$data['quangcao'] = $advManager->select($advModel);		
		//print_r($data['quangcao']); die;
		$this->load->view('rvlisting.html',$data);
		$this->load->view('footer.html');
	}
	
	/**
	 * 
	 * Load header
	 * 
	 */
	
	public function loadHeader2($seo) {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$url = site_url('raovat');		
		if (isset($seo) && $seo->getTitle()!='') {
			$data['seo'] = $seo;
		}
		else
			$data['seo'] =$seoManager->_select($url);		
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();		
		$categoryModel->setParentId(0);
		$categoryModel->setVisible(1);
		$data['category'] = $categoryManager->select($categoryModel);
		$categoryModel = new MbCategoryModel();		
		$categoryModel->setParentId(0);				
		$data['category2'] = $categoryManager->select($categoryModel);	
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			$categoryModel->setParentId($cat_id);
			$data['subcat'][$value->getId()] = $categoryManager->select($categoryModel);	
		}
		if ($this->checklogin()) {
			$this->load->library('session');
			$data['account'] = $this->session->userdata('account');			
			$this->load->view('header_login.html',$data);
		}
		else {				
			$this->load->view('header.html',$data);
		}		
	}
	
	public function checklogin() {
		$this->load->model('mbusermanager');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		if (!$userManager->isLogin()) {
			return false;
		}
		return true;
	}	
	
	public function loadHeader() {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$url = site_url('raovat');		
		$data['seo'] =$seoManager->_select($url);		
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();		
		$categoryModel->setParentId(0);
		$categoryModel->setVisible(1);
		$data['category'] = $categoryManager->select($categoryModel);
		$categoryModel = new MbCategoryModel();		
		$categoryModel->setParentId(0);				
		$data['category2'] = $categoryManager->select($categoryModel);			
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			$categoryModel->setParentId($cat_id);
			$data['subcat'][$value->getId()] = $categoryManager->select($categoryModel);	
		}
		if ($this->checklogin()) {
			$this->load->library('session');
			$data['account'] = $this->session->userdata('account');			
			$this->load->view('header_login.html',$data);
		}
		else {		
			$this->load->view('header.html',$data);
		}		
	}
	
	/**
	 * 
	 *  hien thi rao vat theo chu de
	 * 
	 */
	
	public function xemraovat($cat_id='',$page=0,$type=0,$page1=0,$need=0,$page2=0) {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbraovatmanager');
		$this->load->model('mbraovatmodel');
		$this->load->model('mbneedmanager');
		$this->load->model('mbneedmodel');	
		$this->load->model('mbtypemanager');
		$this->load->model('mbtypemodel');		
		$this->load->model('mbprovincemodel');	
		$this->load->library('pagination');
		$cat_id = intval($cat_id);
		/*	
		$cat_id = explode("-", $cat_id);
		$cat_id = intval($cat_id[0]);
		*/
		$type = explode("-", $type);
		$type = intval($type[0]);		
		$need = explode("-", $need);
		$need = intval($need[0]);				
		// new category model
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();		
		$raovatManager = new MbRaoVatManager();
		$categoryModel->setParentId(0);			
		$data['category'] = $categoryManager->select($categoryModel);	
		$limit = 50;
		$province = isset($province)?$province:0;
		$district = isset($district)?$district:0;
		$type = isset($type)?$type:0;
		$need = isset($need)?$need:0;
		$parse = array("cat_id"=>$cat_id,
		"province"=>$province,
		"district"=>$district,
		"type"=>$type,
		"need"=>$need);
		$total = $raovatManager->getTotalRaoVat($parse);
		if ($cat_id!='' && $type==0 && $need==0) {
			$config['base_url'] = site_url('raovat/xemraovat').'/'.$cat_id;
			$config['uri_segment'] = 4;
		}
		else if ($type!=0) {
			$config['base_url'] = site_url('raovat/xemraovat').'/'.$cat_id.'/0/'.$type;
			$config['uri_segment'] = 6;			
		}
		else if ($need!=0) {
			$config['base_url'] = site_url('raovat/xemraovat').'/'.$cat_id.'/0/0/0/'.$need;
			$config['uri_segment'] = 8;			
		}
        $config['total_rows'] = $total;   
        $config['per_page'] = '50';       
		if ($page1!=0) $page = $page1;
		if ($page2!=0) $page = $page2; //print_r($config);
        $this->pagination->initialize($config);	
        $limit = $config['per_page'];
        $paging = $this->pagination->create_links();
        $rvdata['paging'] = $paging; 
        $rvdata['rvbycat'] = $raovatManager->getRaoVat($parse,$limit,$page);
		if ($cat_id!='' && $cat_id!=0) {
			$categoryModel->setId($cat_id);
			$categoryModel = $categoryManager->select($categoryModel);
			$rvdata['cat'] = $categoryModel[0];
		}
		else {
			$rvdata['cat'] = new MbCategoryModel();
		}
		$typeManager = new MbTypeManager();		
		$rvdata['type'] = $typeManager->select($cat_id);
		$needManager = new MbNeedManager();		
		$rvdata['need'] = $needManager->select($cat_id);
		$provinceModel = new MbProvinceModel();
		$provinceModel->setId($province);		
		$rvdata['province'] = $provinceModel;
		$this->loadHeader();
		$this->load->view('rvlistbycat.html',$rvdata);
		$this->load->view('footer.html');
		
	}

	public function xemtheotinh($province=0,$page=0,$district='',$page1=0) {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbraovatmanager');
		$this->load->model('mbraovatmodel');
		$this->load->model('mbneedmanager');
		$this->load->model('mbneedmodel');	
		$this->load->model('mbtypemanager');
		$this->load->model('mbtypemodel');		
		$this->load->model('mbprovincemodel');	
		$this->load->library('pagination');	
		$province = explode("-", $province);
		$province = intval($province[0]);
		// new category model
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();		
		$raovatManager = new MbRaoVatManager();
		$categoryModel->setParentId(0);			
		$data['category'] = $categoryManager->select($categoryModel);	
		$limit = 50;
		$cat_id = isset($cat_id)?$cat_id:0;
		$province = isset($province)?$province:0;
		$district = isset($district)?$district:0;
		$type = isset($type)?$type:0;
		$need = isset($need)?$need:0;
		$parse = array("cat_id"=>$cat_id,
		"province"=>$province,
		"district"=>$district,
		"type"=>$type,
		"need"=>$need);
		$total = $raovatManager->getTotalRaoVat($parse);
		if ($district=='') {
			$config['base_url'] = site_url('raovat/xemtheotinh').'/'.$province;
			$config['uri_segment'] = 4;			
		} else {
			$config['base_url'] = site_url('raovat/xemtheotinh').'/'.$province.'/0/'.$district;
			$config['uri_segment'] = 6;
		}
        $config['total_rows'] = $total;   
        $config['per_page'] = '50';       
        if ($page1!=0) $page = $page1;
        $this->pagination->initialize($config);	
        $limit = $config['per_page'];
        $paging = $this->pagination->create_links();
        $rvdata['paging'] = $paging; 
        $rvdata['rvbycat'] = $raovatManager->getRaoVat($parse,$limit,$page);
		if ($cat_id!='' && $cat_id!=0) {
			$categoryModel->setId($cat_id);
			$categoryModel = $categoryManager->select($categoryModel);
			$rvdata['cat'] = $categoryModel[0];
		}
		else {
			$rvdata['cat'] = new MbCategoryModel();
		}
		$typeManager = new MbTypeManager();		
		$rvdata['type'] = $typeManager->select($cat_id);
		$needManager = new MbNeedManager();		
		$rvdata['need'] = $needManager->select($cat_id);
		$provinceModel = new MbProvinceModel();
		$provinceModel->setId($province);		
		$rvdata['province'] = $provinceModel;
		$this->loadHeader();
		$this->load->view('rvlistbyprovince.html',$rvdata);
		$this->load->view('footer.html');
		
	}
	
	
	
	/**
	 * 
	 * dang tin rao vat
	 * 
	 */
	
	public function dangraovat() {
		$this->load->model('mbhomeservice');
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		// new category model
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();		
		// $homeService = new MbHomeService();
		$this->loadHeader();
		$categoryModel->setParentId(0);				
		/*$this->load->view('header.html',$data);*/
		$data['category'] = $categoryManager->select($categoryModel);
		$user_id = $this->getUserId();
		$data['user_id'] = $user_id;
		$count = 0;
		if (isset($user_id)) {
			$sql = "SELECT count(*) as count FROM mb_user WHERE id_=".$user_id." AND active_=1";
			$result = $this->db->query($sql);
			$row = $result->result_array();					
			$count = $row[0]['count'];
			if ($count>0) {		
				$this->load->view('raovat.html',$data);
			}			
			else {
				$this->load->view('baned.html');
			}
		}
		else {
			$this->load->view('raovat.html',$data);
		}
		$this->load->view('footer.html');
	}
	
	/**
	 * dang tin khuyen mai
	 */
	 
	public function tinkhuyenmai($id=0) {
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$id = intval($id);
		$tintucModel = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();		
		if ($id!=0) {
			$tintucModel->setId($id);
			$tintucinfo = $tintucManager->select($tintucModel);
		}
		else {
			$tintucinfo[0]= new MbTinTucModel();
		}		
		$data['tin'] = array();
		//$data['tin'] = $tintucManager->select($tintucModel);
		$data['tintucinfo'] = $tintucinfo[0];
		//print_r($data['tin']);
		$this->load->model('mbnewscatmanager');
		$this->load->model('mbnewscatmodel');
		$newscatManager = new MbNewsCatManager();
		$newscatModel = new MbNewsCatModel();		
		$data['newscat'] = $newscatManager->select($newscatModel);
		$this->loadHeader();
		$this->load->view("tinkm.html",$data);		
		$this->load->view('footer.html');
	}
	 
	
	public function getType() {
		$cat_id=isset($_POST['cat_id'])?$_POST['cat_id']:'';
		$this->load->model('mbtypemanager');
		$this->load->model('mbtypemodel');
		$typeManager = new MbTypeManager();
		$typeModel = new MbTypeModel();	
		$result = $typeManager->select($cat_id);
		echo "<option value=0>-- Chọn chủng loại --</option>";
		foreach ($result as $value) {
			echo "<option value='".$value->getId()."'>".$value->getType()."</option>";
		}	
	}
	
	/**
	 * 
	 * 
	 */
	
	public function getNeed() {
		$cat_id=isset($_POST['cat_id'])?$_POST['cat_id']:'';
		$this->load->model('mbneedmanager');
		$this->load->model('mbneedmodel');
		$needManager = new MbNeedManager();
		$needModel = new MbNeedModel();	
		$result = $needManager->select($cat_id);
		echo "<option value=0>-- Chọn nhu cầu --</option>";		
		foreach ($result as $value) {
			echo "<option value='".$value->getId()."'>".$value->getNeed()."</option>";
		}	
	}
	
	public function suatin() {
		$subject = isset($_POST['subject'])?$_POST['subject']:'';
		$content = isset($_POST['content'])?$_POST['content']:'';
		$cat_id = isset($_POST['ad_cat_id'])?$_POST['ad_cat_id']:'';
		$province = isset($_POST['ad_city_id'])?$_POST['ad_city_id']:'';
		$subCategory = isset($_POST['ad_id_pcat'])?$_POST['ad_id_pcat']:'';
		$type = isset($_POST['ad_id_subcat'])?$_POST['ad_id_subcat']:'';
		$district = isset($_POST['use_district'])?$_POST['use_district']:'';
		$user_id = isset($_POST['user_id'])?$_POST['user_id']:'';
		$id_ = isset($_POST['id_'])?$_POST['id_']:'';
		$this->load->model('mbraovatmanager');
		$this->load->model('mbraovatmodel');		
		
		$raovatManager = new MbRaovatManager();
		$raovatModel = new MbRaovatModel();	
		$raovatModel->setId($id_);
		$raovatModel->setSubject($subject);
		$raovatModel->setContent($content);
		$raovatModel->setCatId($cat_id);
		$raovatModel->setProvince($province);
		$raovatModel->setDistrict($district);
		$raovatModel->setSubCategory($subCategory);
		$raovatModel->setType($type);
		$raovatModel->setUserId($user_id);
		$date = date("Y-m-d H:i:s");
		$raovatModel->setDate($date);
		$raovatManager->update($raovatModel);	
		redirect(site_url('myitem'));
		
	}	
	
	
	/**
	 *  dang tin rao vat
	 *  @param ngay bo sung 5/11/2011 sub_cat_, type_, district_
	 *  @author: truong
	 */
	
	public function dangtin() {
	
	    /* captcha */
		  require_once('recaptchalib.php');
		  $privatekey = "6LfmbSUTAAAAAGDDE6ZMOsj36ps2M1YaJyJGF_y8";
		  $resp = recaptcha_check_answer ($privatekey,
										$_SERVER["REMOTE_ADDR"],
										$_POST["recaptcha_challenge_field"],
										$_POST["recaptcha_response_field"]);

		  if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
			die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
				 "(reCAPTCHA said: " . $resp->error . ")");
		  } else {
		  	
		$subject = isset($_POST['subject'])?$_POST['subject']:'';
		$content = isset($_POST['content'])?$_POST['content']:'';
		$cat_id = isset($_POST['ad_cat_id'])?$_POST['ad_cat_id']:'';
		$province = isset($_POST['ad_city_id'])?$_POST['ad_city_id']:'';
		$subCategory = isset($_POST['ad_id_pcat'])?$_POST['ad_id_pcat']:'';
		$type = isset($_POST['ad_id_subcat'])?$_POST['ad_id_subcat']:'';
		$district = isset($_POST['use_district'])?$_POST['use_district']:'';
		$user_id = isset($_POST['user_id'])?$_POST['user_id']:'';
		$this->load->model('mbraovatmanager');
		$this->load->model('mbraovatmodel');		
		
		$raovatManager = new MbRaovatManager();
		$raovatModel = new MbRaovatModel();	

		$raovatModel->setSubject($subject);
		$raovatModel->setContent($content);
		$raovatModel->setCatId($cat_id);
		$raovatModel->setProvince($province);
		$raovatModel->setDistrict($district);
		$raovatModel->setSubCategory($subCategory);
		$raovatModel->setType($type);
		$raovatModel->setUserId($user_id);
		$date = date("Y-m-d H:i:s");
		$raovatModel->setDate($date);
		$raovatManager->insert($raovatModel);	
        include 'mailer.php';
        $subject = 'Tin dang moi muarenhat.vn -'.$subject;
        $msg = 'Ngay dang tin: '.$date.'<br>';
        $msg .= 'Noi dung tin: <br>'.$content;
        // send mail to sonlocdien@gmail.com
        smtpmailer('muarenhatvn.mailer@gmail.com', 'muarenhatvn.mailer@gmail.com', 'Mua Re Nhat', $subject, $msg);
        
		redirect(site_url());
		
		}// end captcha
	}	
	
	/**
	* dang khuyenmai
	*/
	
	public function dangtinkm() {
		error_reporting(0);
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$title = $_POST['title'];
		$url = $_POST['url'];
		$img = $_POST['img_src'];
		$summary = $_POST['summary'];
		$news_detail = $_POST['news_detail'];
		$order = isset($_POST['sort'])?$_POST['sort']:'';
		$cat = $_POST['cat'];
		
		/* upload file */
		
		$target_path = "images/";

        $image_file_src = $target_path. basename( $_FILES['img_file_src']['name']);

        $target_path = $target_path . basename( $_FILES['img_file_src']['name']); 
        if ($_POST['id']=='' || $img!='') {
	        if ($img=='' || $_FILES['img_file_src']['tmp_name']!='') {
	
		        if (move_uploaded_file($_FILES['img_file_src']['tmp_name'],$target_path)) {
		
		        }
		        else{
		            die("<font color='red'>There was an error uploading the file, please try again!</font>");
		        }
	        }				
        }
		
		$tintucModel = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();
		if ($_FILES['img_file_src']['tmp_name']!='') {
			$tintucModel->setImg($image_file_src);
		}
		else
		if (isset($img) && $img!='') {
			$tintucModel->setImg($img);
		}
		else {
			$tintucModel->setImg($image_file_src);
		}		
		$tintucModel->setUrl($url);
		$tintucModel->setTitle($title);
		$tintucModel->setSummary($summary);
		$tintucModel->setDetail($news_detail);
		$tintucModel->setPriority($order);
		$tintucModel->setCat($cat);
		$date = date("Y-m-d H:i:s");
		$tintucModel->setDate($date);
		$id = $_POST['id'];
		if ($id=='') {
			$tintucManager->insert($tintucModel);
		}
		else {
			$tintucModel->setId($id);
			$tintucManager->update($tintucModel);
		}
		redirect(site_url('tintuc'));		
	} 

	/**
	 * xem tin da dang
	 * 
	 */
	
	public function xemtin($id) {
		/*
		 * tang so pageview
		 * 
		 */
		$id=intval($id);
		$sql = "UPDATE mb_raovat set page_view=page_view+1 WHERE id_=".$id;
		//die($sql);
		$this->db->query($sql);
		$this->load->model('mbhomeservice');
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbraovatmanager');
		$this->load->model('mbraovatmodel');		
		$this->load->model('mbtypemodel');
		$this->load->model('mbneedmodel');
		$this->load->model('mbtypemanager');
		$this->load->model('mbneedmanager');
		$this->load->model('mbseomodel');
		$raovatManager = new MbRaovatManager();
		$raovatModel = new MbRaovatModel();
		$raovatModel->setId($id);
		$raovatList = $raovatManager->_select($raovatModel);		
		if (sizeof($raovatList) == 0) {
			$rvdata['raovat'] = $raovatModel;
			return;
		} else {
			$rvdata['raovat'] = $raovatList[0];
		}
		$typeManager = new MbTypeManager();
		$needManager = new MbNeedManager();
		$type_id = $raovatList[0]->getType();
		$typeModel = $typeManager->_select($type_id);
		$need_id = $raovatList[0]->getSubCategory();
		$needModel = new MbNeedModel();
		$needModel = $needManager->_select($need_id);
		if (count($typeModel)>0)
		$rvdata['type'] = $typeModel[0]->getType();
		else 
		$rvdata['type'] = '';
		if (count($needModel)>0)
			$rvdata['need'] = $needModel[0]->getNeed();
		else 
			$rvdata['need'] = '';
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$cat_id = $raovatList[0]->getCatId();
		$rvdata['cat'] = '';
		if ($cat_id!='') {
			$categoryModel->setId($cat_id);
			$categoryModelArray = $categoryManager->select($categoryModel);
			if (is_array($categoryModelArray) && count($categoryModelArray)>0) {
				$rvdata['cat'] = $categoryModelArray[0];
			}
		}
		else {
			$rvdata['cat'] = '';
		}
		$seo = new MbSeoModel();
		$title = $rvdata['raovat']->getSubject()." | muarenhat.net";
		$seo->setTitle($title);
		$seo->setDescription($title);
		$title = str_replace("|","",$title);
		$title = str_replace("  "," ",$title);
		$keyword = str_replace(" ",",",$title);		
		$seo->setKeyword($keyword);
		$this->loadHeader2($seo);
		$raovatModel = new MbRaoVatModel();
		$raovatModel->setCatId($cat_id);
		$rvdata['thesamecat'] = $raovatManager->selectByPage($raovatModel,20,0);
		$user_id = $rvdata['raovat']->getUserId();
		$rvdata['user'] = $this->getUserInfo($user_id);
		// tin vip
		$rvdata['tinvip'] = $raovatManager->_tinvip($cat_id);
		$this->load->view('xemraovat.html',$rvdata);
		$this->load->view('footer.html');
	}
	
	public function getUserId() {
		$this->load->library('session');
		$account = $this->session->userdata('account');
		if (empty($account)) return;
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$userModel = new MbUserModel();
		$userModel->setAccount($account);
		$userManager = new MbUserManager();
		$userInfo = $userManager->select($userModel);
		if (count($userInfo)>0) {
			return $userInfo[0]->getId();
		}
		return ;
	}
	
	public function getUserInfo($user_id) {
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");		
		$userModel = new MbUserModel();
		$userModel->setId($user_id);
		$userManager = new MbUserManager();
		$result = $userManager->select($userModel);
		$user = new MbUserModel();
		if (count($result)>0) {
			$user=$result[0];
		}
		return $user;
	}
}

/* End of file raovat.php */
/* Location: ./application/controllers/raovat.php */


