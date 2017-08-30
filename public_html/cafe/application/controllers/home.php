<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->model("mbproductmodel");
		$this->load->model("mbproductmanager");
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$tintuc = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();
		$data['topnews'] = $tintucManager->select_top();
		$sql = "SELECT * FROM mb_sys";
		$query = $this->db->query($sql);
		$result = $query->result();
		$data['footer'] = $result[0];		
		$sql = "SELECT * FROM mb_vote";
		$query = $this->db->query($sql);
		$result = $query->result();
		$data['vote'] = $result[0];				
		$this->load->view('header.html',$data);
		$this->load->view('home.html',$data);
		$this->loadFooter();
		if (isset($_POST['cmd']) && isset($_POST['v'])) {
			$vote_result = $_POST['v'];
			$sql = "UPDATE mb_vote set ".$vote_result." = ".$vote_result." + 1";
			$this->db->query($sql);
		}
	}
	
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