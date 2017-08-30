<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

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
			$tintucModel = new MbTinTucModel();
			$tintucManager = new MbTinTucManager();					
			$tintucModel->setId($id);
			$tintucinfo = $tintucManager->select($tintucModel);
			if (isset($tintucinfo[0])) {
			//$this->loadHeader($tintucinfo[0]);
			$newscatModel->setParentId(0);
			$data['category'] = $newscatManager->select($newscatModel);
			$data['news'] = $tintucinfo[0];
			$catid=$tintucinfo[0]->getCat();
			$tintucModel = new MbTinTucModel();
			$tintucModel->setCat($catid);
			$data['tin'] = $tintucManager->select($tintucModel);
			$data['tinhot'] = $tintucManager->select_top_hot();	
			$advModel = new MbAdvModel();
			$advManager = new MbAdvManager();
			//$advModel->setRaovat(1);
			$data['quangcao'] = $advManager->select($advModel);
			// die(count($data['quangcao']));
			$raovatManager = new MbRaoVatManager();
                        $data['topraovat'] = $raovatManager->getTopRaoVat();
                        //echo $data['news']->getCat()."<br>";
                        //echo $data['news']->getDetail(); die();
                        $this->load->view("newhtml.html",$data);
                        /*
			$this->load->view("news.html",$data);
			$this->load->view('footer.html');*/
			}		
		}
		
	}
	
	/**
	 *  load header
	 *  @author: truong
	 *
	 */

	public function loadHeader($tin) {
		/* SEO */
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$seo = new MbSeoModel();
		$title = $tin->getTitle()." - muarenhat.net";
		$seo->setTitle($title);
		$seo->setDescription($title);
		$title = str_replace("|","",$title);
		$title = str_replace("  "," ",$title);
		$keyword = str_replace(" ",",",$title);		
		$seo->setKeyword($keyword);		
		//$url = site_url();		
		$data['seo'] =$seo;		
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

