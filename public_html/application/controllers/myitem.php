<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MyItem extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/myaccount
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
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mbusermanager');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		if (!$userManager->isLogin()) {
			redirect(site_url('login'));
		}		
	}
	
	public function index($page=0)
	{
		$this->load->library('session');
		$account = $this->session->userdata('account');
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$userModel = new MbUserModel();
		$userModel->setAccount($account);
		$userManager = new MbUserManager();
		$result = $userManager->select($userModel);
		$user = new MbUserModel();
		if (count($result)>0) {
			$user=$result[0];
		}
		$userId=$user->getId();
		//update tinh trang uptin
		$sql = "UPDATE mb_raovat SET status_=0 WHERE user_id_=$userId AND ABS(DATEDIFF(date_,SYSDATE()))>=1";
		$this->db->query($sql);
		$this->load->model('mbraovatmanager');
		$this->load->model('mbraovatmodel');
		$raovatModel = new MbRaoVatModel();
		$raovatModel->setUserId($userId);
		$raovatManager = new MbRaoVatManager();
		// paging
		$total = count($raovatManager->_select($raovatModel));
		$this->load->library('pagination');	        
        $config['base_url'] = site_url('myitem');
		$config['total_rows'] = $total; 
		$config['uri_segment'] = 2;
        $config['per_page'] = '30';       
        $this->pagination->initialize($config);	
        $limit = $config['per_page'];
        $paging = $this->pagination->create_links(); //print_r($paging); //die;
        $raovat['paging'] = $paging;			
		$raovat['myitem'] = $raovatManager->selectByPage($raovatModel,$limit,$page);
		//print_r($raovat['myitem']); die;		
		$this->loadHeader();
		$this->load->view("myitem.html",$raovat);
		$this->load->view("footer.html");
	}
	
	/*
	 * Sua tin rao vat
	 * 3/4/2012
	 */
	
	public function edit($id) {
		$this->load->model('mbhomeservice');
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		// new category model
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();		
		// $homeService = new MbHomeService();
		$this->loadHeader();
		$categoryModel->setParentId(0);				
		/*$this->load->view('header.html',$data);*/
		$data['category'] = $categoryManager->select($categoryModel);		
		// $this->loadHeader();
		$id = intval($id);
		$sql = "SELECT r.id_,r.subject_,r.cat_id_,r.sub_cat_,r.type_,r.province_,r.district_,r.content_,r.user_id_ FROM mb_raovat r LEFT JOIN mb_user u ON r.user_id_=u.id_ WHERE r.id_=".$id;
		$query = $this->db->query($sql);
		$result = $query->result();
		if (count($result)>0) {			
			$raovat = $result[0];
			// print_r($raovat);
			$data['raovat']=$raovat;	
			$data['user_id']=$raovat->user_id_;
			//print_r($raovat);
			$this->load->view("editraovat.html",$data);
		}
	}
	
	
	
	/**
	 *  xoa tin rao vat
	 * 
	 */
	
	public function removeraovat($id) {
		$this->load->model('mbraovatmanager');
		$this->load->model('mbraovatmodel');		
		$raovatManager = new MbRaovatManager();
		$raovatModel = new MbRaovatModel();
		$raovatModel->setId($id);
		$raovatManager->delete($raovatModel);
		redirect(site_url('myitem'));		
	}
	/* load file header */
	
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


