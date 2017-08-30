<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {

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
	 *  chi tiet tin tuc
	 * 
	 */
	
	public function index($id=0)
	{  
		$id=intval($id);
		if ($id>0) {
			$this->load->model("mbcontentmodel");
			$this->load->model("mbcontentmanager");
			$this->load->model('mbadvmanager');	
			$this->load->model('mbadvmodel');		
			$contentModel = new MbContentModel();
			$contentManager = new MbContentManager();								
			$contentModel->setId($id);
			$contentinfo = $contentManager->select($contentModel);
			if (isset($contentinfo[0])) {
				$this->loadHeader();
				$data['cms'] = $contentinfo[0];
				$advModel = new MbAdvModel();
				$advManager = new MbAdvManager();
				$data['quangcao'] = $advManager->select($advModel);
				$this->load->view("cms.html",$data);
				$this->load->view('footer.html');
			}		
		}
		
	}
	
	/**
	 *  load header
	 *  @author: truong
	 *
	 */

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



