<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lienhe extends CI_Controller {

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
	public function index()
	{		
			if (isset($_POST['cmd'])) {
			$name = isset($_POST['name'])?$_POST['name']:'';
			$email = isset($_POST['email'])?$_POST['email']:'';
			$phone = isset($_POST['phone'])?$_POST['phone']:'';
			$mobile = isset($_POST['mobile'])?$_POST['mobile']:'';
			$subject = isset($_POST['subject'])?$_POST['subject']:'';
			$content = isset($_POST['content'])?$_POST['content']:'';
			require("mailer.php");
			$sql = "SELECT * FROM mb_user WHERE account_='admin'";
			$query = $this->db->query($sql);
			$result = $query->result();			
			$to = $result[0]->email_;
			$from = $email;
			$from_name = $name;
			//$subject = "Lien he quang cao";
			$body = "Ho va ten: ".$name;
			//$body .= "<br>Dia chi: ".$address;
			$body .= "<br>Dien thoai: ".$phone;
			$body .= "<br>Di dong: ".$mobile;
			//$body .= "<br>Fax: ".$fax;
			$body .= "<br>Email: ".$email;
			$body .= "<br>Noi dung: ".$content;
			$ok = smtpmailer($to, $from, $from_name, $subject, $body);	
			if ($ok) {
			    //header("location:http://muarenhat.net");
				//echo "This form is sent!";
			}
			
		}		
		$this->load->model("mbslidermodel");
		$this->load->model("mbslidermanager");
		$sliderModel = new MbSliderModel();
		$sliderManager = new MbSliderManager();
		$data['slider'] = $sliderManager->select($sliderModel);		
		/**
		 * thu 2 - chu nhat
		 * 
		 */
		$this->load->model("mbcategorymodel");
		$this->load->model("mbcategorymanager");
		$category = new MbCategoryModel();
		$categoryManager = new MbCategoryManager();
		$data['days'] = $categoryManager->select($category); 
		/**
		 *  end thu 2 - chu nhat
		 */			
		$this->load->view('header.html',$data);
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$tintuc = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();
		$data['topnews'] = $tintucManager->select_top();	

		/** 
		 * load support online 
		*/
		$this->load->model("mbsupportmodel");
		$this->load->model("mbsupportmanager");
		$support = new MbSupportModel();
		$supportManager = new MbSupportManager();
		$data['support'] = $supportManager->select($support);
		/**
		 * end support online
		 */
		
		$this->load->view('lienhe.html',$data);
		$this->loadFooter();
	}
	
	// load footer
	public function loadFooter() {
		$sql = "SELECT * FROM mb_sys";
		$query = $this->db->query($sql);
		$result = $query->result();
		$data['footer'] = $result[0];
		$this->load->view('footer.html',$data);
	}		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
