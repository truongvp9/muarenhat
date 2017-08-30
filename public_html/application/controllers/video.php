<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller {

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
		$id = intval($id);
		$this->load->model("mbvideomodel");
		$this->load->model("mbvideomanager");
		$this->load->model('mbadvmanager');	
		$this->load->model('mbadvmodel');		
		$this->load->model('mbraovatmanager');	
		$this->load->model('mbraovatmodel');					
		$advModel = new MbAdvModel();
		$advManager = new MbAdvManager();
		$data['quangcao'] = $advManager->select($advModel);
		if ($id!=0) {
			$videoModel = new MbVideoModel();
			$videoModel->setId($id);
			$videoManager = new MbVideoManager();
			$videolist = $videoManager->select($videoModel);
			if (count($videolist)>0) {
				$data['video'] = $videolist[0];
			}			
			else {
				$data['video'] = $videoModel;
			}
			$this->loadHeader($videolist[0]);
			$videoModel = new MbVideoModel();
			$videoManager = new MbVideoManager();
			// $data['videolist'] = $videoManager->selectTop($videoModel);	
			$data['videokhac'] = $videoManager->select($videoModel);		
			$this->load->view("video.html",$data);
		}
		else {
			// list all video
			// $this->loadHeader();
			$videoModel = new MbVideoModel();
			$videoManager = new MbVideoManager();
			$data['videolist'] = $videoManager->selectTop($videoModel);
			$data['videokhac'] = $videoManager->select($videoModel);
			$videoModel->setTitle("Video");
			$this->loadHeader($videoModel);
			$raovatManager = new MbRaoVatManager();
		    $data['topraovat'] = $raovatManager->getTopRaoVat();				
			$this->load->view("videolist.html",$data);
		}
		$this->load->view("footer.html");
	}
	
	/**
	 *  load header
	 *  @author: truong
	 *
	 */

	public function loadHeader($video) {
		/* SEO */
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$seoManager = new MbSeoManager();
		$seo = new MbSeoModel();
		$title = $video->getTitle()." Video - muarenhat.net";
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
?>
