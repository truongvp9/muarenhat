<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newslist extends CI_Controller {

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
	 *  liet ke cac tin
	 * 
	 */
	
	public function index($cid=0)
	{  		
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$this->load->model('mbnewscatmanager');
		$this->load->model('mbnewscatmodel');	
		$this->load->model('mbadvmanager');	
		$this->load->model('mbadvmodel');	
		$this->load->model('mbraovatmanager');	
		$this->load->model('mbraovatmodel');			
		$newscatManager = new MbNewsCatManager();
		$newscatModel = new MbNewsCatModel();	
		/*if ($cid>0) {
			$newscatModel->setParentId($cid);
		}
		else {
			$newscatModel->setParentId(0);
		}*/			
		
		$newscatModel->setParentId(0);
		$cid = intval($cid);
		$tintucModel = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();		
		if ($cid!=0) {
			$tintucModel->setCat($cid);
		}
			$tin= $tintucManager->selectByPage($tintucModel,10,0);
			$data['tin'] = $tin;
			$tinkhac= $tintucManager->selectByPage($tintucModel,100,10);
			$data['tinkhac'] = $tinkhac;
			$this->loadHeader();
			$data['category'] = $newscatManager->select($newscatModel);
			$advModel = new MbAdvModel();
			$advManager = new MbAdvManager();
			$data['quangcao'] = $advManager->select($advModel);	
			$raovatManager = new MbRaoVatManager();
		    $data['topraovat'] = $raovatManager->getTopRaoVat();				
			$this->load->view('newslist.html',$data);
			$this->load->view('footer.html');
			// print_r($tintucinfo);				
	}
	
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

