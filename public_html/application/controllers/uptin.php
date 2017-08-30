<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uptin extends CI_Controller {
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
	// up tin
	public function up() {
		$id = $_POST['id'];
		$key = $_POST['key'];
		$valid_key = sha1('muaban!2');
		$this->load->model("mbraovatvip");
		if ($key==$valid_key) {
			$this->mbraovatvip->uptin($id);
		}
	}
	
	// TIN VIP
	public function vip() {
		$id = $_POST['id'];
		$key = $_POST['key'];
		$valid_key = sha1('muaban!2');
		$this->load->model("mbraovatvip");
		if ($key==$valid_key) {
			$this->mbraovatvip->tinvip($id);
		}
	}
	
}

