<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/sanpham
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
	 
	public function index($id)
	{
		$sql = "UPDATE mb_product set page_view=page_view+1 WHERE id_=".$id;
		//die($sql);
		$this->db->query($sql);		
		$this->load->model('mbseomodel');
		$this->load->model('mbhomeservice');
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');		
		$this->load->model("mbproductmodel");
		$this->load->model("mbproductmanager");
		$productManager = new MbProductManager();
		$productModel = new MbProductModel();
		$id= intval($id);
		$productModel->setId($id);
		$productInfo = $productManager->select($productModel);
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
		if (count($productInfo)>0) {
			$data['product'] = $productInfo[0];
			$cat_id = $productInfo[0]->getCategory();
			$data['cat'] = $categoryManager->selectBreadcrumb($cat_id);
			$user_id = $productInfo[0]->getUserId();			
			$this->load->model("mbusermodel");
			$this->load->model("mbusermanager");
			$userModel = new MbUserModel();
			$userModel->setId($user_id);
			$userManager = new MbUserManager();
			$result = $userManager->select($userModel);
			$user = new MbUserModel();
			if (count($result)>0) {
				$user=$result[0];//print_r($user);
			}		
			$data['user'] = $user;
			$productModel = new MbProductModel();
			$productModel->setCategory($cat_id);
			$data['relate_product'] = $productManager->selectByPage($productModel,5,0);
			$productModel = new MbProductModel();
			$userid = $productInfo[0]->getUserId();
			$productModel->setUserId($userid);
			$data['thesame_saler'] = $productManager->selectByPage($productModel,5,0);	
			$seo = new MbSeoModel();
			$title = $data['product']->getName();
			$seo->setTitle($title);
			$seo->setDescription($title);
			$title = str_replace("  "," ",$title);
			$title = str_replace("(","",$title);
			$title = str_replace(")","",$title);
			$title = str_replace("/","",$title);
			$title = str_replace(",","",$title);
			$keyword = str_replace(" ",",",$title);
			$seo->setKeyword($keyword);
			$this->loadHeader($seo);
			$this->load->view("product_detail.html",$data);
			// $this->load->view("test.html");
			$this->load->view("footer.html");			
		}		
	}
	
	/**
	 * Load header
	 * @author: truong
	 */
	
	public function loadHeader($seo) {
		/* SEO */
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$url = site_url('sanpham');		
		$data['seo'] = $seo;
		// $seoManager->_select($url);		
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

