<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

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
	public function index($id=0)
	{
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
		// $this->load->view('header.html');
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$tintuc = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();
		$data['topnews'] = $tintucManager->select_top();	
		// news detail
		$id=intval($id);
		if ($id>0) {
			$tintucModel = new MbTinTucModel();
			$tintucManager = new MbTinTucManager();					
			$tintucModel->setId($id);
			$tintucinfo = $tintucManager->select($tintucModel);
			if (isset($tintucinfo[0])) {
				$data['news'] = $tintucinfo[0];
			}	
			$tintucModel = new MbTinTucModel();
			$data['tin'] = $tintucManager->select($tintucModel);		
		}		
		
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
		
		
		$this->load->view('news_detail.html',$data);		
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
