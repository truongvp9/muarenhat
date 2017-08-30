<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {

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
		$id=intval($id);
		if ($id>0) {
			$this->load->model("mbcontentmodel");
			$this->load->model("mbcontentmanager");
			$contentModel = new MbContentModel();
			$contentManager = new MbContentManager();								
			$contentModel->setId($id);
			$contentinfo = $contentManager->select($contentModel);
			if (isset($contentinfo[0])) {
				$this->load->view("header.html");
				$data['cms'] = $contentinfo[0];
				$this->load->view("cms.html",$data);
				//$this->load->view('footer.html');
			}		
			$this->loadFooter();
		}
		
	}
	
	/**
	 * load footer
	 * 
	 */
	
	public function loadFooter() {
		$sql = "SELECT * FROM mb_sys";
		$query = $this->db->query($sql);
		$result = $query->result();
		$data['footer'] = $result[0];
		$this->load->view('footer.html',$data);
	}
	
	
}
