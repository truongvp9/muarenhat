<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batdongsan extends CI_Controller {

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
	 
	 /** Chuyen trang bat dong san */
	
	public function index()
	{  
		$this->loadHeader();
		$districts = array("Hoàn Kiếm", "Ba Ðình", "Ðống Ða", "Hai Bà Trưng", "Tây Hồ", "Thanh Xuân", "Cầu Giấy", "Long Biên", "Hoàng Mai", "Hà Đông","TX.Sơn Tây","H.Ðông Anh", "H.Sóc Sơn", "H.Thanh Trì", "H.Từ Liêm", "H.Gia Lâm", "H.Ba Vì", "H.Chương Mỹ", "H.Đan Phượng", "H.Hoài Đức", "H.Mỹ Đức", "H.Phú Xuyên", "H.Phúc Thọ", "H.Quốc Oai", "H.Thạch Thất", "H.Thanh Oai", "H.Thường Tín", "H.Ứng Hòa", "H.Mê Linh");
		$data['district'] = $districts;
		$this->load->view('batdongsan.html',$data);
		$this->load->view('footer.html');
	}
	
	/**
	 *  load header
	 *  @author: truong
	 *
	 */
	
	public function loadHeader() {
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
		$this->load->view('header.html',$data);		
	}
}

