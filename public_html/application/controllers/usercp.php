<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserCp extends CI_Controller {
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

	public function changepassword() {
		$id = $_POST['id'];
		$id = intval($id);
		$password = sha1($_POST['password']);
		$current_password = sha1($_POST['n_passcurrent']);
		$key = $_POST['key'];
		$valid_key = sha1('muaban!2');
		if ($key==$valid_key && $id>0) {
			$sql = "SELECT * FROM mb_user WHERE id_=".$id." AND password_='".$current_password."'";
			$query =$this->db->query($sql);//die($sql);
			if ($query->num_rows()>0) {
				$sql = "UPDATE mb_user SET password_='".$password."' WHERE id_=".$id;
				$this->db->query($sql);
				echo "200";
			}
			else {
				echo "Mật khẩu hiện thời chưa đúng!";
			}
		}
	}
	
		public function savemap() {
		$id = $_POST['id'];
		$id = intval($id);
		$lat = $_POST['lat'];
		$lng = $_POST['lng'];
		$key = $_POST['key'];
		$valid_key = sha1('muaban!2');
		if ($key==$valid_key && $id>0) {
			$sql = "SELECT * FROM mb_store WHERE owner_=".$id;
			$query =$this->db->query($sql);
			if ($query->num_rows()>0) {
				$sql = "UPDATE mb_store SET map_latitude_='".$lat."',map_longitude_='".$lng."' WHERE owner_=".$id;
				$this->db->query($sql);
				echo "200";
			}
			else {
				echo "Gian hàng không tồn tại!";
			}
		}
	}	
}

