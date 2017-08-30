<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link extends CI_Controller {

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
	
	public function index() {
		// lien ket web
		$this->loadHeader();
		$this->load->model("mblinkmodel");
		$this->load->model("mblinkmanager");
		$linkModel = new MbLinkModel();
		$linkManager = new MbLinkManager();
		$kw = isset($_GET['kw'])?$_GET['kw']:'';
		if ($kw!='') {
			$linkModel->setUrl($kw);
		}
		$data['link'] = $linkManager->select($linkModel);
		$this->load->view("link.html",$data);
		$this->load->view("footer.html");
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



