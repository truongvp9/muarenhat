<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hoidap extends CI_Controller {

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
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function index($page=0)
	{
		$this->loadHeader();
		$this->load->library('pagination');		
		$this->load->model('mbquestionmanager');
		$this->load->model('mbquestionmodel');
		$this->load->model('mbadvmanager');	
		$this->load->model('mbadvmodel');	
		$this->load->model('mbraovatmanager');	
		$this->load->model('mbraovatmodel');					
		$hoidapModel = new 	MbQuestionModel();
		$hoidapManager = new MbQuestionManager();
		$config['base_url'] = site_url('admin/hoidap'); 
		$total = $hoidapManager->getTotal();
        $config['total_rows'] = $total;       
        $config['per_page'] = '20';       
        $this->pagination->initialize($config);	
        $limit = $config['per_page'];	
		$data['hoidap'] = $hoidapManager->select($limit,$page);
		$page = 2;
		$data['hoidapkhac'] = $hoidapManager->select($limit,$page);
		//$data['hoidapkhac'] = $data['hoidapkhac'];
        $paging = $this->pagination->create_links();
        $data['paging'] = $paging;        
		$advModel = new MbAdvModel();
		$advManager = new MbAdvManager();
		$data['quangcao'] = $advManager->select($advModel);	
	    $raovatManager = new MbRaoVatManager();
		$data['topraovat'] = $raovatManager->getTopRaoVat();	        
		$this->load->view('listhoidap.html',$data);
		$this->load->view('footer.html');
	}
	
	public function danghoidap()
	{
		// dang nhap moi duoc dang cau hoi
		$this->load->model('mbusermanager');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		if (!$userManager->isLogin()) {
			redirect(site_url('login'));
		}		
		//
		$this->loadHeader();
		$data['userid'] = $this->getUserId();
		$this->load->view('hoidap.html',$data);
		$this->load->view('footer.html');
	}
	
	public function reply($qid) {
		if ($this->checklogin()) {
		if (isset($_POST['qid'])) {
			$user_id = $this->getUserId();
			$date_answer = date("Y-m-d H:i:s");
			$content = isset($_POST['content'])?$_POST['content']:'';
			$sql = "INSERT INTO mb_answer (qid_,date_answer_,answer_content_,userid_) VALUES ('".$_POST['qid']."','".$date_answer."','".$content."',$user_id)";
			$this->db->query($sql);
			redirect(site_url('hoidap/chitiet/'.$_POST['qid']));
		}
		if (intval($qid)!=0) {
			$this->load->model('mbquestionmodel');
			$this->load->model('mbquestionmanager');
			$hoidapModel = new 	MbQuestionModel();
			$hoidapManager = new MbQuestionManager();	
			$hoidap = $hoidapManager->selectbyid($qid);	
			$data['item'] = $hoidap[0];
			$this->loadHeader();
			$this->load->view('reply.html',$data);
			$this->load->view('footer.html');
		}	
		}
		else {
			redirect(site_url('login'));
		}	
	}
	
	public function chitiet($qid=0) {
		$this->load->model('mbadvmodel');				
		$this->load->model('mbadvmanager');	
		$this->load->model('mbquestionmanager');
		$this->load->model('mbquestionmodel');		
		$qid = intval($qid);	
		$sql = "SELECT q.cat_id_,q.qid_,date_ask_,title_,ask_content_, date_answer_,answer_content_,u.account_ account_ask,u2.account_ as account_reply FROM mb_question q join mb_answer a ON q.qid_=a.qid_ JOIN mb_category c on q.cat_id_=c.id_ LEFT JOIN mb_user u on u.id_=q.userid_ LEFT JOIN mb_user u2 on u2.id_ = a.userid_ WHERE q.qid_=".$qid." ORDER BY a.date_answer_ DESC";
		// echo $sql; die;
		$query = $this->db->query($sql);
		$data['result'] = $query->result();
		if (count($data['result']) > 0) {
		//print_r($data['result']);
		$advModel = new MbAdvModel();
		$advManager = new MbAdvManager();
		$title = $data['result'][0]->title_;
		$this->loadHeader($title);
		//$advModel->setRaovat(1);
		$data['quangcao'] = $advManager->select($advModel);
		$cid = $data['result'][0]->cat_id_;
		$hoidapManager = new MbQuestionManager();		
		$data['hoidapcd'] = $hoidapManager->selectbycid($cid);
		$this->load->view('chitiethoidap.html',$data);
		$this->load->view('footer.html');
		}
	}
	
	public function loadHeader($title='') {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');		
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		if ($title=='') {
			$url = site_url('raovat');		
			$data['seo'] =$seoManager->_select($url);
		}
		else {
			$seo = new MbSeoModel();
			$seo->setTitle($title);
			$seo->setDescription($title);
			$title = str_replace("|","",$title);
			$title = str_replace("  "," ",$title);
			$keyword = str_replace(" ",",",$title);		
			$seo->setKeyword($keyword);	
			$data['seo'] = $seo;
		}	
		// new category model
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
	
	public function dangcauhoi() {
		$this->load->model("mbquestionmanager");
		$this->load->model("mbquestionmodel");
		$questionManager = new MbQuestionManager();
		$questionModel = new MbQuestionModel();
		$title = isset($_POST['hd_name'])?$_POST['hd_name']:'';
		$ask_content = isset($_POST['hd_cauhoi'])?$_POST['hd_cauhoi']:'';
		$catid = isset($_POST['cat_id'])?$_POST['cat_id']:'';
		$userid = isset($_POST['userid'])?$_POST['userid']:0;
		$questionModel->setTitle($title);
		$questionModel->setAskContent($ask_content);
		$questionModel->setCatId($catid);
		$questionModel->setDateAsk(date("Y-m-d H:i:s"));
		$questionModel->setUserId($userid);
		$questionManager->_insert($questionModel);
		// var_dump($questionModel);
		redirect(site_url('hoidap'));
	}
	
	public function getUserId() {
		$this->load->library('session');
		$account = $this->session->userdata('account');
		if (empty($account)) return;
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$userModel = new MbUserModel();
		$userModel->setAccount($account);
		$userManager = new MbUserManager();
		$userInfo = $userManager->select($userModel);
		if (count($userInfo)>0) {
			return $userInfo[0]->getId();
		}
		return ;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */


