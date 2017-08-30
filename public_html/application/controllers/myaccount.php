<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myaccount extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/myaccount
	 *	- or -  
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	*/
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mbusermanager');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		if (!$userManager->isLogin()) {
			redirect(site_url('login'));
		}		
	}
	 
	public function index()
	{
		$this->load->library('session');
		$account = $this->session->userdata('account');
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$userModel = new MbUserModel();
		$userModel->setAccount($account);
		$userManager = new MbUserManager();
		$result = $userManager->select($userModel);
		$user = new MbUserModel();
		if (count($result)>0) {
			$user=$result[0];
		}
		$this->loadHeader();
		//$this->load->view("admin/header_admin.html",array('user'=>$user));	
		$this->load->view("myaccount.html",array('user'=>$user));
		$this->load->view("footer.html");
	}
	
	public function updateProfile() {
				
			$this->load->model("mbusermodel");
			$this->load->model("mbusermanager");
		    $account = $_POST['username'];
			$userModel = new MbUserModel();
			$userModel->setAccount($account);
			$userModel->setName($_POST['use_name']);		
			$userModel->setEmail($_POST['use_email']);
			$userModel->setPhone($_POST['use_phone']);
			$userModel->setMobile($_POST['use_mobile']);
			$userModel->setFax($_POST['use_fax']);
			$userModel->setAddress($_POST['use_address']);
			$userModel->setYM($_POST['use_yahoo']);
			$userModel->setSkype($_POST['use_skype']);
			$userModel->setWebsite($_POST['use_website']);
			$userManager = new MbUserManager();
			$userManager->update($userModel);
		    redirect(site_url('myaccount'));
	}
	
	/* load file header */
	
	public function loadHeader() {
		/* SEO */
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$url = site_url();		
		$data['seo'] =$seoManager->_select($url);		
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
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
}

