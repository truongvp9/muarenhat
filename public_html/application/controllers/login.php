<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
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
		session_start();
		$data['host'] = $this->config->site_url();
		$this->loadHeader();
		$status = $login = $password ='';	
		if (isset($_POST['login'])) {
			$status = $this->authenticate();
			$login = $_POST['login'];
			$password = $_POST['pass'];
		}
		$data['status'] = $status;
		$data['password'] = $password;
		$data['login'] = $login;
		$this->load->view("login.html",$data);
		$this->load->view("footer.html");			
	}
	/* load header */
	
	public function loadHeader() {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$url = site_url();		
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
		$this->load->view('header.html',$data);		
	}	
	
	// authenticate user & pass
	public function authenticate() {
		//session_start();
		$account = $_POST['login'];
		$password = sha1($_POST['pass']);
		$this->load->model('mbusermanager');
		$this->load->model('mbusermodel');
		$mbUserModelManager = new MbUserManager();
		$mbUserModel = new MbUserModel();
		$mbUserModel->setAccount($account);
		$mbUserModel->setPassword($password);
		$okie = $mbUserModelManager->authenticate($mbUserModel);
		$msg = '';
		if ($okie>=1) {
				$this->load->library('session'); 
			    $newdata = array(
                       'account'  => $_POST['login'],
                       'logged_in' => TRUE
                );
				//print_r($_SESSION['cart']); die;
              	$this->session->set_userdata($newdata);   				
                if ($newdata['account']=='admin' || $newdata['account']=='hoangtn') {
					//print_r($newdata['account']); die;
                	redirect(site_url('admin/gianhang'));
                }   
                else if (isset($_SESSION['cart'])) {
                	redirect(site_url('checkout'));
                }       
				else {
					redirect(site_url());
				}
		}
		else {
			//echo sha1('hanoi123');
			$msg = "Tên truy nhập hoặc mật khẩu sai!";// Neu ban chua dang ky thi click <a href=".site_url('register').">vao day</a> de dang ky!";			
		}
		return $msg;
	}

}

