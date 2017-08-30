<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {

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
	 *  shopping cart
	 * 
	 */
	
	public function index()
	{  		
		session_start();
		$this->loadHeader();
		$data['cart'] = isset($_SESSION['cart'])?$_SESSION['cart']:array('pid'=>array());
		$this->load->model("mbproductmodel");
		$this->load->model("mbproductmanager");
		$productManager = new MbProductManager();
		$basket = array();
		$total = 0;
		if (is_array($data['cart']['pid'])) {
		foreach ($data['cart']['pid'] as $pid) {
			$productModel = new MbProductModel();
			// echo $item;
			$productModel->setId($pid);
			$product = $productManager->select($productModel);
		    if (isset($product) & count($product)>0) {
				// print_r($product[0]);
				$basket[$pid]['product'] =  $product[0];
				$basket[$pid]['quantity'] =  $data['cart']['quantity'][$pid];
				$price_temp = intval($product[0]->getPrice()*$basket[$pid]['quantity']);
				$basket[$pid]['price'] = $this->getNicePrice(intval($product[0]->getPrice()*$basket[$pid]['quantity']));
				$total+=$price_temp;				
		    }
		}
		}
		$data['basket'] = $basket;
		$data['total'] = $this->getNicePrice($total);
		$this->load->view("cart.html",$data);
		$this->load->view("footer.html");
	}
	// add to cart
	public function addtocart($id) {
		session_start();
		$_SESSION['cart']['pid'][$id] = $id;
		$_SESSION['cart']['quantity'][$id] = isset($_SESSION['cart']['quantity'][$id])?$_SESSION['cart']['quantity'][$id]:0;
		if (isset($_SESSION['cart']['pid'][$id])) {
			$_SESSION['cart']['quantity'][$id] = $_SESSION['cart']['quantity'][$id]+1;
		}
		else {
			$_SESSION['cart']['quantity'][$id] = 1;
		}
		redirect(site_url('cart'));
	}
	// remove product from cart
	public function remove($id) {
		session_start();
		unset($_SESSION['cart']['pid'][$id]);
		unset($_SESSION['cart']['quantity'][$id]);
		redirect(site_url('cart'));
	}
	// empty cart
	public function emptycart() {
		session_start();
		unset($_SESSION['cart']);
		redirect(site_url('cart'));
	}

	// empty cart
	public function recalculate() {
		session_start();
		$quantity = isset($_POST['quantity'])?$_POST['quantity']:array();		
		foreach ($quantity as $key => $value) {
			if ($value>0) {
				$_SESSION['cart']['quantity'][$key] = $value;
			}
		}
		redirect(site_url('cart'));
	}
	
	public function getNicePrice($price)
	{
		if (intval($price)==0) {
			return 0;
		}
		$price_st = strrev($price);
		$arr = str_split($price_st,3);
		$result = implode(".", $arr);
		$result= strrev($result);
	    return $result;
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


