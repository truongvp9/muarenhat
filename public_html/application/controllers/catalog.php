<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/catalog
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
	 
	public function index($category,$page=0)
	{
		$this->load->model('mbhomeservice');
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');		
		$this->load->model("mbproductmodel");
		$this->load->model("mbproductmanager");
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$service = new MbHomeService();
		$data['category'] = $service->queryCategory();
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			$categoryModel->setParentId($cat_id);
			$data['subcat'][$value->getId()] = $categoryManager->select($categoryModel);	
			foreach ($data['subcat'][$value->getId()] as $val) {
				$catid = $val->getId();
				$categoryModel->setParentId($catid);
				$data['subcat_level2'][$val->getId()] = $categoryManager->select($categoryModel);	
			}		
		}	
		$productManager = new MbProductManager();
		$total = $productManager->getTotalProduct($category);
		$this->load->library('pagination');	        
                $config['base_url'] = site_url('catalog').'/'.$category;
		$config['total_rows'] = $total;   
		$config['uri_segment'] = 3;
                $config['per_page'] = '20';       
                $this->pagination->initialize($config);	
                $limit = $config['per_page'];
                $paging = $this->pagination->create_links(); //print_r($paging); //die;
                $data['paging'] = $paging;
		$productInfo = $productManager->selectByRootCategory($category,$limit,$page);
		$this->loadHeader();
		if (count($productInfo)>0) {
			$data['product'] = $productInfo;
			$categoryModel = new MbCategoryModel();
			$categoryModel->setId($category);
			$data['cat'] = $categoryManager->select($categoryModel);			
			$this->load->view("catalog_grid.html",$data);
		}		
		
		$this->load->view("footer.html");		
	}

	/**
	 * Load header
	 * @author: truong
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

