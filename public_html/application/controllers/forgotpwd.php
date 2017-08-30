<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ForgotPwd extends CI_Controller {

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
	 *  forgot password
	 * 
	 */
	
	public function index()
	{  		
		require('mailer.php');
		$email = isset($_POST['email'])?$_POST['email']:'';
		// check email exist
		$sql = "SELECT count(*) as count FROM mb_user WHERE email_='".$email."'";
		$query = $this->db->query($sql);
		$result = $query->result();
		if ($result[0]->count > 0) {
			$sql = "SELECT id_,account_,email_ FROM mb_user WHERE email_='".$email."'";
			$query = $this->db->query($sql);
			$result = $query->result();	
			$item = $result[0];		
			$key = sha1($item->account_);
			$from = "muarenhat.mailer@gmail.com";
			$from_name = "Mua Re Nhat";
			$subject = "[muarenhat.net] Lay lai mat khau";
			$body = "Xin chào bạn,<br>

					Chúng tôi nhận được yêu cầu reset lại mật khẩu đăng nhập website muarenhat.net.<br> Hệ thống sẽ tự động tạo lại mật khẩu mới và gửi tới email $email nếu bạn click vào link sau:<br>
					
					<a href='http://muarenhat.net/forgotpwd/reset/$item->id_/$key'>http://muarenhat.net/forgotpwd/reset/$item->id_/$key</a><br>
					
					( Bạn có thể copy và paste link sau và chạy trên trình duyệt: http://muarenhat.net/forgotpwd/reset/$item->id_/$key )<br>
					
					MuaRenhat.net";
			smtpmailer($email, $from, $from_name, $subject, $body);
			$msg = "Một Email đã được gửi đến $email. Vui lòng kiểm tra email và làm theo hướng dẫn.";
		}
		else {
			$msg = "Email của bạn không tồn tại trong hệ thống.";
		}
		$this->loadHeader();
		$data['msg'] = $msg;
		$this->load->view("forgotpwd.html",$data);
		$this->load->view("footer.html");
		//redirect(site_url());
		//print_r($result);
	}
	
	public function reset($userid,$key) {
		require('mailer.php');
		$sql = "SELECT email_,account_ FROM mb_user WHERE id_='".$userid."'";
		$query = $this->db->query($sql);
		$result = $query->result();
		$newpwd = $this->generatePassword();
		if (count($result)>0) {
			$email = $result[0]->email_;
			$account = $result[0]->account_;
			if ($key==sha1($account)) {
				$sql="UPDATE mb_user SET password_='".sha1($newpwd)."' WHERE id_=".$userid;
				$this->db->query($sql);
				$msg = "Xin chào bạn,<br>
				Chúng tôi nhận được yêu cầu reset lại mật khẩu đăng nhập website muarenhat.net Thông tin về tài khoản của bạn như sau:<br>
				
				ID của bạn: $userid<br>
				Tên truy nhập: $account<br>
				Password: $newpwd<br>
				
				Ngay sau khi đăng nhập, bạn vui lòng đổi lại mật khẩu để đảm bảo cho sự an toàn thông tin rao của bạn.
				";
				
			}
			else {
					$msg = 'Sai mã xác thực!';
			}
			$from = "muarenhat.mailer@gmail.com";
			$from_name = "Mua Re Nhat";
			$subject = "[muarenhat.net] Lay lai mat khau";			
			smtpmailer($email, $from, $from_name, $subject, $msg);
		}
		redirect(site_url('login'));
	}
	
	public function generatePassword($length=9, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
	
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


