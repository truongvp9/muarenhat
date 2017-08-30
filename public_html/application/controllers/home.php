<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
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
	 
	public function index()
	{
		$this->load->model('mbhomeservice');
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbraovatmanager');
		$this->load->model('mbraovatmodel');
		$this->load->model('mbproductmanager');
		$this->load->model('mbproductmodel');
		$this->load->model('mbadvmanager');	
		$this->load->model('mbadvmodel');			
		$service = new MbHomeService();
		$raovatManager = new MbRaoVatManager();
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$productdata['topraovat'] = $raovatManager->getTopRaoVat();
		//$service->querySubject();
		$productdata['productList'] = $service->queryProduct();
		$productdata['category'] = $service->queryCategory();
		$data['category2'] = $service->queryCategory(1);
		$data['category'] = $productdata['category'];
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
		$advModel = new MbAdvModel();
		$advManager = new MbAdvManager();
		$productdata['quangcao'] = $advManager->select($advModel);
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$url = site_url();		
		$data['seo'] =$seoManager->_select($url);
		/* check login */
		if ($this->checklogin()) {
			$this->load->library('session');
			$data['account'] = $this->session->userdata('account');
			$this->load->view("header_login.html",$data);
		}
		else {
			$this->load->view("header.html",$data);
		}
		/* add module tintuc */
		
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");

		//$tintucModel = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();	

		$productdata['tin'] = $tintucManager->select_top();
		// slider
		$this->load->model("mbslidermodel");
		$this->load->model("mbslidermanager");
		$sliderModel = new MbSliderModel();
		$sliderManager = new MbSliderManager();
		$productdata['slider'] = $sliderManager->select($sliderModel); 		
		$this->load->view("productlist.html",$productdata);
		$this->load->view("footer.html");
	}
	
	public function checklogin() {
		$this->load->model('mbusermanager');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		if (!$userManager->isLogin()) {
			// redirect(site_url('login'));
			return false;
		}
		return true;
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */


