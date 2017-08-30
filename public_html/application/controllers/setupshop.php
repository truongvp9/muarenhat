<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setupshop extends CI_Controller {

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
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mbusermanager');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		$this->load->library('session');
		$account = $this->session->userdata('account');
		if (!$userManager->isLogin()) {
			redirect(site_url('login'));
		}
		$this->load->library('session');
		$account = $this->session->userdata('account');
		$sql = "SELECT count(*) as count FROM mb_user u join mb_store s on u.id_=s.owner_ WHERE u.account_='".$account."' AND u.active_=1";
		$query = $this->db->query($sql);
		$result = $query->result();
		$active = $result[0]->count;
		if (!$active) {
			redirect(site_url());
		}		
		
		if ($active) {
			$sql = "SELECT s.id_ FROM mb_user u join mb_store s on u.id_=s.owner_ WHERE u.account_='".$account."' AND u.active_=1";
			$query = $this->db->query($sql);
			$result = $query->result();
			$store_id = $result[0]->id_;			
			$_SESSION['store_id'] = $store_id;
		}
	}
	
	/**
	 *  set up a shop
	 * 
	 */
	 
	public function index() {
		
	}
	
	/**
	 *  config store
	 * 
	 */
	
	public function config() {
		$this->loadHeader();		
		$store_id = isset($_SESSION['store_id'])?$_SESSION['store_id']:1;
		$skin_id = isset($_SESSION['skin_id'])?$_SESSION['skin_id']:'shopthoitrang';
		$this->load->model("mbstoremodel");
		$this->load->model("mbstoremanager");		
		$storeModel = new MbStoreModel();		
		$storeModelManager = new MbStoreManager();		
		$storeModel->setId($store_id);
		$store = $storeModelManager->select($storeModel);
		$store_info = $store[0];
		//print_r($store_info);die;
		$data['store_info'] = $store_info;
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');		
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();	
		$categoryModel->setParentId(0);
		$categoryModel->setVisible(1);		
		$data['category'] = $categoryManager->select($categoryModel);
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			$categoryModel->setParentId($cat_id);
			$data['subcat'][$value->getId()] = $categoryManager->select($categoryModel);	
		}							
		$this->load->view("gianhang/gianhang_config.html",$data);
		$this->load->view('footer.html');
		
	}
	
	/**
	 *  luu cau hinh gian hang
	 * 
	 */
	
	public function do_config() {
		$store_id = isset($_SESSION['store_id'])?$_SESSION['store_id']:1;
		$skin_id = isset($_POST['skin_id'])?$_POST['skin_id']:'shopthoitrang';		
		$this->load->model("mbstoremodel");
		$this->load->model("mbstoremanager");		
		$storeModel = new MbStoreModel();		
		$storeModelManager = new MbStoreManager();		
		$introduction = isset($_POST['introduction'])?$_POST['introduction']:'';
		$policy = isset($_POST['policy'])?$_POST['policy']:'';
		$contact = isset($_POST['contact'])?$_POST['contact']:'';
		$cat_id = isset($_POST['cat_id'])?$_POST['cat_id']:'';	
		$storeModel->setId($store_id);					
		$storeModel->setIntroduction($introduction);
		$storeModel->setPolicy($policy);
		$storeModel->setContact($contact);
		$storeModel->setSkin($skin_id);
		$storeModel->setCatId($cat_id);
		$storeModelManager->config($storeModel);
		redirect(site_url('setupshop/config'));		
	}

	public function setcategory() {
		$store_id = isset($_SESSION['store_id'])?$_SESSION['store_id']:1;
		$skin_id = isset($_SESSION['skin_id'])?$_SESSION['skin_id']:'shopthoitrang';
		$this->load->model("mbstorecatmodel");
		$this->load->model("mbstorecatmanager");
		$storecatModel = new MbStoreCatModel();
		$storecatManager = new MbStoreCatManager();
		$storecatModel->setStoreId($store_id);
		$storecatModel->setParentId(0);
		$storecatList = $storecatManager->select($storecatModel);
		$storecatManager = new MbStoreCatManager();
		$storecatModel->setStoreId($store_id);
		$category = $storecatManager->select($storecatModel);
		$data['category'] = $storecatList;
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();			
			$storecatModel = new MbStoreCatModel();
			$storecatModel->setStoreId($store_id);
			$storecatModel->setParentId($cat_id);
			$data['subcat'][$value->getId()] = $storecatManager->select($storecatModel);	
		}		
		$data['catalog'] = $storecatList;
		//$this->load->view("gianhang/gianhang_header.html");
		$this->loadHeader();
		$this->load->view("gianhang/addcategory.html",$data);
		$this->load->view('footer.html');
		// print_r($data); die;
		//$this->load->view("gianhang/gianhang_footer.html");
		// print_r($storecatList);
	}
	
	/**
	* edit store category
	*/
	
	public function editstorecat($id) {
		$store_id = isset($_SESSION['store_id'])?$_SESSION['store_id']:1;
		$skin_id = isset($_SESSION['skin_id'])?$_SESSION['skin_id']:'shopthoitrang';
		$this->load->model("mbstorecatmodel");
		$this->load->model("mbstorecatmanager");
		$storecatModel = new MbStoreCatModel();
		$storecatManager = new MbStoreCatManager();
		$storecatModel->setStoreId($store_id);
		$storecatList = $storecatManager->select($storecatModel);
		$storecatModel->setId($id);
		$storeCat = $storecatManager->select($storecatModel);
		$data['category'] = $storecatList;
		$data['cat'] = $storeCat[0];
		$this->loadHeader();
		$this->load->view("gianhang/editcategory.html",$data);
		$this->load->view('footer.html');	
	}
	
	
	public function add_new_cat() {		
		$store_id = isset($_SESSION['store_id'])?$_SESSION['store_id']:1;
		$skin_id = isset($_SESSION['skin_id'])?$_SESSION['skin_id']:'shopthoitrang';
		$this->load->model("mbstorecatmodel");
		$this->load->model("mbstorecatmanager");
		$storecatModel = new MbStoreCatModel();
		$storecatManager = new MbStoreCatManager();	
		$cat_name = $_POST['cat_name'];
		$cat_id = $_POST['cat_id'];
		$storecatModel->setName($cat_name);
		$storecatModel->setStoreId($store_id);
		$storecatModel->setParentId($cat_id);
		$storecatManager->insert($storecatModel);
		redirect(site_url('setupshop/setcategory'));
	}
	
	public function do_edit_cat() {
		$store_id = isset($_SESSION['store_id'])?$_SESSION['store_id']:1;
		$skin_id = isset($_SESSION['skin_id'])?$_SESSION['skin_id']:'shopthoitrang';
		$this->load->model("mbstorecatmodel");
		$this->load->model("mbstorecatmanager");
		$storecatModel = new MbStoreCatModel();
		$storecatManager = new MbStoreCatManager();	
		$cat_name = $_POST['cat_name'];
		$parent_id = $_POST['parent_id'];
		$cat_id = $_POST['cat_id'];
		$storecatModel->setId($cat_id);
		$storecatModel->setName($cat_name);
		$storecatModel->setStoreId($store_id);
		$storecatModel->setParentId($parent_id);
		$storecatManager->update($storecatModel);
		redirect(site_url('setupshop/setcategory'));
	}
	
	/**
	 *  delete news category
	 * 
	 */
	
	public function deletestorecat($id) {
		$this->load->model("mbstorecatmodel");
		$this->load->model("mbstorecatmanager");
		$storecatModel = new MbStoreCatModel();
		$storecatManager = new MbStoreCatManager();	
		$storecatModel->setId($id);
		$storecatManager->delete($storecatModel);
		redirect(site_url('setupshop/setcategory'));
	}	
	
	
	public function loadHeader() {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');		
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$url = site_url('raovat');		
		$data['seo'] =$seoManager->_select($url);	
		// new category model
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


