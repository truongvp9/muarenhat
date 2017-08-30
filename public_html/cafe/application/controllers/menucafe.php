<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menucafe extends CI_Controller {

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
		$this->load->view("header.html");
		/** load products */
		$this->load->model("mbproductmodel");
		$this->load->model("mbproductmanager");		
		$product = new MbProductModel();
		$productManager = new MbProductManager();
		$data['listproduct'] = $productManager->selectByPage($product,10,0);
		/** end load products */		
		$this->load->view("menucafe.html",$data);
		$this->loadFooter();
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