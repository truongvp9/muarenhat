<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {

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
	 *  show store home page
	 * 
	 */
	
	public function index($account='')
	{  
	    if ($account!='') {
		// echo $account; die;
		$sql = "SELECT s.id_,s.skin_ FROM mb_user u join mb_store s ON u.id_=s.owner_ WHERE u.account_='$account'";
		$query = $this->db->query($sql);
		$result = $query->result();
		if (count($result)>0) {
			$store_id= $result[0]->id_;
			$skin_id= $result[0]->skin_;		
		}	
		else {
			$store_id=1;
			$skin_id="shopthoitrang";
		}
		$this->load->model("mbstorecatmodel");
		$this->load->model("mbstorecatmanager");	
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$this->load->model("mbproductmodel");
		$this->load->model("mbproductmanager");
		$this->load->model("mbstoremodel");
		$this->load->model("mbstoremanager");	
		// get user_id	
		$storeModel = new MbStoreModel();		
		$storeModelManager = new MbStoreManager();		
		$storeModel->setId($store_id);
		$store = $storeModelManager->select($storeModel);
		$store_info = $store[0];
		$userid = $store_info->getOwner();
		$data['store_info'] = $store_info;		
		$productManager = new MbProductManager();
		$productModel = new MbProductModel();		
		$storeCatManager = new MbStoreCatManager();
		$storeCatModel = new MbStoreCatModel();		
		$tintucModel = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();							
		$storeCatModel->setStoreId($store_id);
		$storeCatModel->setParentId(0);
		$productModel->setUserId($userid);
		$data['product'] = $productManager->selectByPage($productModel,5,0);			
		$cat_list = $storeCatManager->select($storeCatModel);
		$sub_cat = array();
		foreach ($cat_list as $item) {
			$storeCatModel = new MbStoreCatModel();
			$storeCatModel->setStoreId($store_id);
			$storeCatModel->setParentId($item->getId());			
			$sub_cat_list = $storeCatManager->select($storeCatModel);
			$sub_cat[$item->getId()] = $sub_cat_list;
		}
		// check login
		$this->load->model('mbusermodel');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		$this->load->library('session');
		//$account = $this->session->userdata('account');
		$login = 0;
		if ($userManager->isLogin()) {
			$login = 1;
		}
		$userModel = new MbUserModel();
		$userModel->setId($userid);
		$userInfo = $userManager->select($userModel);
		$data['storeInfo'] = $userInfo[0];
		$data['login'] = $login;
		$data['tin'] = $tintucManager->select_top();
		$data['cat_list'] = $cat_list;
		$data['sub_cat'] = $sub_cat;
		$data['store_id'] = $store_id;
		$data['skin_id'] = $skin_id;
		$data['account'] = $account;
		$this->load->view("skin/".$skin_id."/header.html",$data);
		$this->load->view("skin/".$skin_id."/index.html",$data);
		$this->load->view("skin/".$skin_id."/footer.html");		
		}
	}
	
	// list all product of a catalog
	
	public function catalog($account,$store_cat_id) {
		$sql = "SELECT s.id_,s.skin_ FROM mb_user u join mb_store s ON u.id_=s.owner_ WHERE u.account_='$account'";
		$query = $this->db->query($sql);
		$result = $query->result();
		if (count($result)>0) {
			$store_id= $result[0]->id_;
			$skin_id= $result[0]->skin_;		
		}	
		else {		
			$store_id=1;
			$skin_id="shopthoitrang";
		}		
		$this->load->model("mbstorecatmodel");
		$this->load->model("mbstorecatmanager");	
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");		
		$this->load->model("mbstoremodel");
		$this->load->model("mbstoremanager");			
		// get user_id	
		$storeModel = new MbStoreModel();		
		$storeModelManager = new MbStoreManager();		
		$storeModel->setId($store_id);
		$store = $storeModelManager->select($storeModel);
		$store_info = $store[0];
		$userid = $store_info->getOwner();
		$data['store_info'] = $store_info;				
		$this->load->model("mbproductmodel");
		$this->load->model("mbproductmanager");
		$productManager = new MbProductManager();
		$productModel = new MbProductModel();	
		$productModel->setStoreCatId($store_cat_id);	
		$data['product'] = $productManager->selectByPage($productModel,5,0);
		$storeCatManager = new MbStoreCatManager();
		$storeCatModel = new MbStoreCatModel();	
		$storeCatModel->setStoreId($store_id);	
		$storeCatModel->setParentId(0);
		$tintucModel = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();			
		$cat_list = $storeCatManager->select($storeCatModel);
		$sub_cat = array();
		foreach ($cat_list as $item) {
			$storeCatModel = new MbStoreCatModel();
			$storeCatModel->setStoreId($store_id);
			$storeCatModel->setParentId($item->getId());			
			$sub_cat_list = $storeCatManager->select($storeCatModel);
			$sub_cat[$item->getId()] = $sub_cat_list;
		}		
		// check login
		$this->load->model('mbusermodel');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		$this->load->library('session');
		//$account = $this->session->userdata('account');
		$login = 0;
		if ($userManager->isLogin()) {
			$login = 1;
		}
		$userModel = new MbUserModel();
		$userModel->setId($userid);
		$userInfo = $userManager->select($userModel);
		$data['storeInfo'] = $userInfo[0];
		$data['login'] = $login;
		$data['tin'] = $tintucManager->select_top();
		$data['cat_list'] = $cat_list;
		$data['sub_cat'] = $sub_cat;
		$data['store_id'] = $store_id;
		$data['skin_id'] = $skin_id;		
		$data['account'] = $account;
		$this->load->view("skin/".$skin_id."/header.html",$data);
		$this->load->view("skin/".$skin_id."/catalog.html",$data);
		$this->load->view("skin/".$skin_id."/footer.html");						
		//print_r(count($data['product'])); die();	
	}
	
	public function cms($account,$page) { 
		// get store info
		$sql = "SELECT s.id_,s.skin_ FROM mb_user u join mb_store s ON u.id_=s.owner_ WHERE u.account_='$account'";
		$query = $this->db->query($sql);
		$result = $query->result();
		if (count($result)>0) {
			$store_id= $result[0]->id_;
			$skin_id= $result[0]->skin_;		
		}	
		else {		
			$store_id=1;
			$skin_id="shopthoitrang";
		}
		$this->load->model("mbstoremodel");
		$this->load->model("mbstoremanager");		
		$storeModel = new MbStoreModel();		
		$storeModelManager = new MbStoreManager();		
		$storeModel->setId($store_id);			
		$store = $storeModelManager->select($storeModel);
		$store_info = $store[0];
		$data['store_info'] = $store_info;
		// show left menu			
		$this->load->model("mbstorecatmodel");
		$this->load->model("mbstorecatmanager");	
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$storeCatManager = new MbStoreCatManager();
		$storeCatModel = new MbStoreCatModel();		
		$tintucModel = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();							
		$storeCatModel->setStoreId($store_id);
		$storeCatModel->setParentId(0);
		$cat_list = $storeCatManager->select($storeCatModel);
		$sub_cat = array();
		foreach ($cat_list as $item) {
			$storeCatModel = new MbStoreCatModel();
			$storeCatModel->setStoreId($store_id);
			$storeCatModel->setParentId($item->getId());			
			$sub_cat_list = $storeCatManager->select($storeCatModel);
			$sub_cat[$item->getId()] = $sub_cat_list;
		}				
		// check login
		$this->load->model('mbusermodel');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		$this->load->library('session');
		//$account = $this->session->userdata('account');
		$login = 0;
		if ($userManager->isLogin()) {
			$login = 1;
		}
		// get user_id	
		$storeModel = new MbStoreModel();		
		$storeModelManager = new MbStoreManager();		
		$storeModel->setId($store_id);
		$store = $storeModelManager->select($storeModel);
		$store_info = $store[0];
		$userid = $store_info->getOwner();		
		$userModel = new MbUserModel();
		$userModel->setId($userid);
		$userInfo = $userManager->select($userModel);
		$data['storeInfo'] = $userInfo[0];		
		$data['login'] = $login;
		$data['tin'] = $tintucManager->select_top();
		$data['cat_list'] = $cat_list;	
		$data['sub_cat'] = $sub_cat;	
		$data['store_id'] = $store_id;
		$data['skin_id'] = $skin_id;		
		$data['account'] = $account;
		$this->load->view("skin/".$skin_id."/header.html",$data);		
		if ($page == 'gioithieu') {
			$this->load->view("skin/".$skin_id."/gioithieu.html",$data);
		}		
		if ($page == 'chinhsach') {
			$this->load->view("skin/".$skin_id."/chinhsach.html",$data);
		}		
		if ($page == 'lienhe') {
			$this->load->view("skin/".$skin_id."/lienhe.html",$data);
		}
		$this->load->view("skin/".$skin_id."/footer.html");	
	}
	
	public function map($account) {		
		$sql = "SELECT s.id_,s.skin_,s.map_latitude_,s.map_longitude_ FROM mb_user u join mb_store s ON u.id_=s.owner_ WHERE u.account_='$account'";
		$query = $this->db->query($sql);
		$result = $query->result();
		$lat = $lng = 0;
		if (count($result)>0) {
			$store_id= $result[0]->id_;
			$skin_id= $result[0]->skin_;	
			$lat = 	$result[0]->map_latitude_;
			$lng = 	$result[0]->map_longitude_;

		
		$data['lat'] = $lat;
		
		$data['lng'] = $lng;
		
		$this->load->model("mbstorecatmodel");
		$this->load->model("mbstorecatmanager");	
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$this->load->model("mbproductmodel");
		$this->load->model("mbproductmanager");
		$this->load->model("mbstoremodel");
		$this->load->model("mbstoremanager");	
		// get user_id	
		$storeModel = new MbStoreModel();		
		$storeModelManager = new MbStoreManager();		
		$storeModel->setId($store_id);
		$store = $storeModelManager->select($storeModel);
		$store_info = $store[0];
		$userid = $store_info->getOwner();
		$data['store_info'] = $store_info;		
		//$productManager = new MbProductManager();
		//$productModel = new MbProductModel();		
		$storeCatManager = new MbStoreCatManager();
		$storeCatModel = new MbStoreCatModel();		
		$tintucModel = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();							
		$storeCatModel->setStoreId($store_id);
		$storeCatModel->setParentId(0);
		//$productModel->setUserId($userid);
		//$data['product'] = $productManager->selectByPage($productModel,5,0);			
		$cat_list = $storeCatManager->select($storeCatModel);
		$sub_cat = array();
		foreach ($cat_list as $item) {
			$storeCatModel = new MbStoreCatModel();
			$storeCatModel->setStoreId($store_id);
			$storeCatModel->setParentId($item->getId());			
			$sub_cat_list = $storeCatManager->select($storeCatModel);
			$sub_cat[$item->getId()] = $sub_cat_list;
		}
		
		
		// check login
		$this->load->model('mbusermodel');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		$this->load->library('session');
		//$account = $this->session->userdata('account');
		$login = 0;
		if ($userManager->isLogin()) {
			$login = 1;
		}
		$userModel = new MbUserModel();
		$userModel->setId($userid);
		$userInfo = $userManager->select($userModel);
		$data['storeInfo'] = $userInfo[0];
		$data['login'] = $login;
		$data['tin'] = $tintucManager->select_top();
		$data['cat_list'] = $cat_list;
		$data['sub_cat'] = $sub_cat;
		$data['store_id'] = $store_id;
		$data['skin_id'] = $skin_id;
		$data['account'] = $account;		
		
		$this->load->view("skin/".$skin_id."/header.html",$data);

		$this->load->view("skin/".$skin_id."/bando.html",$data);
		
		$this->load->view("skin/".$skin_id."/footer.html");	
		
		}	
		else {
			$store_id=1;
			$skin_id="shopthoitrang";
		}
		
	}		
}


