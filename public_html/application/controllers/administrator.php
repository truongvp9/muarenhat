<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/admin
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
		$this->load->library('session');
		$account = $this->session->userdata('account');		
		if ($account!='admin') {
			redirect(site_url('login'));
		}				
	}
	 
	public function index($page=0)
	{
		// $this->load->database();
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbusermanager');
		$this->load->library('pagination');	
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$categoryModel->setParentId(0);
		$userManager = new MbUserManager();
		// paging
		$total = count($categoryManager->select($categoryModel));
		$limit = 3;
		$config['total_rows'] = $total;   
                $config['per_page'] = '3';       
                $config['base_url'] = site_url('admin/index');
                $this->pagination->initialize($config);	
                $limit = $config['per_page'];
                $paging = $this->pagination->create_links();        
                $data['paging'] = $paging;   
		if ($userManager->isLogin()) {		
			$data['category'] = $categoryManager->selectByPage($categoryModel,$limit,$page);
			foreach ($data['category'] as $value) {
				$cat_id = $value->getId();
				$categoryModel->setParentId($cat_id);
				$data['subcat'][$value->getId()] = $categoryManager->select($categoryModel);	
				foreach ($data['subcat'][$value->getId()] as $val) {
					$catid = $val->getId();
					$categoryModel->setParentId($catid);
					$data['subcat_level2'][$val->getId()] = $categoryManager->select($categoryModel);	
				}		
			}					
			$this->load->view("admin/header_admin.html");	
			$this->load->view("admin/menu.html",$data);
		}
		else {
			redirect(site_url('login'));
		}
	}
	
	/**
	 * My account
	 * @author: truong
	 * Enter description here ...
	 */
	
	public function myaccount() {
		$this->load->library('session');
		$account = $this->session->userdata('account');
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		if (isset($_POST['fullname'])) {
			$userModel = new MbUserModel();
			$userModel->setAccount($account);
			$userModel->setName($_POST['fullname']);		
			$userModel->setEmail($_POST['email']);
			$userManager = new MbUserManager();
			$userManager->update($userModel);
			if (isset($_POST['new_password'])) {
				$password=sha1($_POST['new_password']);
				$sql = "UPDATE mb_user SET password_='".$password."' WHERE account_='".$account."'";
				$this->db->query($sql);
					
			}
		}
		
		$userModel = new MbUserModel();
		$userModel->setAccount($account);
		$userManager = new MbUserManager();
		$result = $userManager->select($userModel);
		$user = new MbUserModel();
		if (count($result)>0) {
			$user=$result[0];
		}
		$this->load->view("admin/header_admin.html",array('user'=>$user));	
		$this->load->view("admin/myaccount.html");
		
	}
	
	/**
	 * Meta info
	 * @author: truong
	 * Enter description here ...
	 */
	
	public function metainfo($url='') {
		$this->load->model("mbseomodel");
		$this->load->model("mbseomanager");
		if (isset($_POST['title']) && $_POST['title']!='') {
			$url = isset($_POST['url'])?$_POST['url']:site_url($url);
			$title = $_POST['title'];
			$keyword = $_POST['keyword'];
			$description = $_POST['description'];
			$seoModel = New MbSeoModel();
			$seoModel->setUrl($url);
			$seoModel->setTitle($title);
			$seoModel->setDescription($description);
			$seoModel->setKeyword($keyword);
			$seoManager = New MbSeoManager();
			$seoManager->_insert($seoModel);
		}
		$seo = new MbSeoModel();
		$seoManager = new MbSeoManager();
		$url = site_url($url);
		$seo = $seoManager->_select($url);
		$this->load->view("admin/header_admin.html");	
		$this->load->view("admin/metainfo.html",array('seo'=>$seo));		
	}
	
	/**
	 * load add new category form
	 * 
	 * @param
	 * 
	 */
	 
	public function addcategory() {
		// $this->load->database();
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		
		$categoryManager = new MBCategoryManager();
		$categoryModel = new MBCategoryModel();
		// $categoryModel->setParentId(0);
		$data['category'] = $categoryManager->select($categoryModel);		
		
		$this->load->view("admin/header_admin.html");	
		$this->load->view("admin/addcategory.html",$data);	
	} 
	
	/**
	 *  Edit a category
	 * 
	 */
	
	public function editcategory($id) {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		/* lay thong tin ve category */
		$categoryModel->setId($id);
		$result = $categoryManager->select($categoryModel);
		$data['cat'] = $result[0];
		/* lay danh muc goc */
		$categoryModel = new MbCategoryModel();
		//$categoryModel->setParentId(0);
		$data['category'] = $categoryManager->select($categoryModel);	
		$data['cat_id'] = $id;
		$this->load->view("admin/header_admin.html");
		$this->load->view("admin/edit_category.html",$data);
	}
	
	/**
	 * @author: truong
	 * Sua loai rao vat
	 * @param int $id
	 */
	
	public function edittype($id) {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbtypemanager');
		$this->load->model('mbtypemodel');		
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$typeManager = new MbTypeManager();
		/* lay thong tin ve type */
		$result = $typeManager->_select($id);
		$data['type'] = $result[0];
		/* lay danh muc goc */
		$categoryModel = new MbCategoryModel();
		$categoryModel->setParentId(0);
		$data['category'] = $categoryManager->select($categoryModel);	
		// $data['cat_id'] = $id;
		$this->load->view("admin/header_admin.html");
		$this->load->view("admin/edit_type.html",$data);		
	}
	

	/**
	 * @author: truong
	 * Sua nhu cau rao vat
	 * @param int $id
	 */
	
	public function editneed($id) {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$this->load->model('mbneedmanager');
		$this->load->model('mbneedmodel');		
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$needManager = new MbNeedManager();
		/* lay thong tin ve need */
		$result = $needManager->_select($id);
		$data['need'] = $result[0];
		/* lay danh muc goc */
		$categoryModel = new MbCategoryModel();
		$categoryModel->setParentId(0);
		$data['category'] = $categoryManager->select($categoryModel);	
		// $data['cat_id'] = $id;
		$this->load->view("admin/header_admin.html");
		$this->load->view("admin/edit_need.html",$data);		
	}	
	
	/**
	 *  delete a category
	 * 
	 */
	
	public function deletecategory($id) {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$categoryModel->setId($id);
		$categoryManager->delete($categoryModel);
		redirect(site_url('admin'));
	}
	
	/**
	 *  set category invisibly
	 * 
	 */
	
	public function setcategory($id,$visible) {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$categoryModel->setId($id);
		$categoryManager->visible($id,$visible);
		redirect(site_url('admin'));
	}
	
	/**
	 *  delete a type
	 * 
	 */
	
	public function deletetype($id) {
		$this->load->model('mbtypemanager');
		$this->load->model('mbtypemodel');
		$typeManager = new MbTypeManager();
		$typeModel = new MbTypeModel();
		$typeModel->setId($id);
		$typeManager->delete($typeModel);
		redirect(site_url('admin/addtype'));
	}
	
	/**
	 *  delete a need
	 * 
	 */
	
	public function deleteneed($id) {
		$this->load->model('mbneedmanager');
		$this->load->model('mbneedmodel');
		$needManager = new MbNeedManager();
		$needModel = new MbNeedModel();
		$needModel->setId($id);
		$needManager->delete($needModel);
		redirect(site_url('admin/addneed'));
	}	
	/**
	 * Them loai rao vat
	 * 
	 */
	
	public function addtype() {
		$this->load->model('mbtypemanager');
		$this->load->model('mbtypemodel');
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$typeManager = new MbTypeManager();
		$typeModel = new MbTypeModel();		
		$categoryModel->setParentId(0);
		$data['category'] = $categoryManager->select($categoryModel);
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			$data['type'][$cat_id] = $typeManager->select($cat_id);	
		}				
		$this->load->view("admin/header_admin.html");	
		$this->load->view("admin/addtype.html",$data);	
	} 
	
	
	/**
	 *  them nhu cau rao vat
	 * 
	 */
	
	public function addneed() {
		$this->load->model('mbneedmanager');
		$this->load->model('mbneedmodel');		
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$needManager = new MbNeedManager();
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$categoryModel->setParentId(0);
		$data['category'] = $categoryManager->select($categoryModel);
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			$data['need'][$cat_id] = $needManager->select($cat_id);	
		}	
		$this->load->view("admin/header_admin.html");	
		$this->load->view("admin/addneed.html",$data);			
	}

	/**
	 * 
	 *  add new need
	 * 
	 * Enter description here ...
	 */
	
	function do_add_need() {
		$this->load->model('mbneedmanager');
		$this->load->model('mbneedmodel');
		$needManager = new MbNeedManager();
		$needModel = new MbNeedModel();
		$need = isset($_POST['need'])?$_POST['need']:'';		
		$catid = isset($_POST['cate_id'])?$_POST['cate_id']:'';
		$needModel->setNeed($need);
		$needModel->setCatId($catid);
		$needManager->insert($needModel);
		redirect(site_url('admin/addneed'));
	}	
	
	/**
	 * 
	 *  add new type
	 * 
	 * Enter description here ...
	 */
	
	function do_add_type() {
		$this->load->model('mbtypemanager');
		$this->load->model('mbtypemodel');
		$typeManager = new MbTypeManager();
		$typeModel = new MbTypeModel();
		$type = isset($_POST['type'])?$_POST['type']:'';		
		$catid = isset($_POST['cate_id'])?$_POST['cate_id']:'';
		$typeModel->setType($type);
		$typeModel->setCatId($catid);
		$typeManager->insert($typeModel);
		redirect(site_url('admin/addtype'));
	}
	
	/**
	 *  edit category
	 * 
	 */
	
	public function do_edit_cat() {
		$id = isset($_POST['cat_id'])?$_POST['cat_id']:'';
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$name = isset($_POST['cat_name'])?$_POST['cat_name']:'';
		$parent_id = isset($_POST['parent_id'])?$_POST['parent_id']:'';
		$categoryModel = new MbCategoryModel();
		$categoryModel->setName($name);
		$categoryModel->setId($id);
		$categoryModel->setParentId($parent_id);
		$categoryManager = new MbCategoryManager();
		$categoryManager->update($categoryModel);
		redirect(site_url('admin'));
	}
	
	/**
	 *  edit type
	 * 
	 */
	
	public function do_edit_type() {
		$id = isset($_POST['id'])?$_POST['id']:'';
		$this->load->model('mbtypemanager');
		$this->load->model('mbtypemodel');
		$type = isset($_POST['type'])?$_POST['type']:'';
		$cat_id = isset($_POST['cat_id'])?$_POST['cat_id']:'';
		$typeModel = new MbTypeModel();
		$typeModel->setType($type);
		$typeModel->setId($id);
		$typeModel->setCatId($cat_id);
		$typeManager = new MbTypeManager();
		$typeManager->_update($typeModel);
		redirect(site_url('admin/addtype'));
	}	
	
	/**
	 *  edit need
	 *  @author: truong
	 */
	
	public function do_edit_need() {
		$id = isset($_POST['id'])?$_POST['id']:'';
		$this->load->model('mbneedmanager');
		$this->load->model('mbneedmodel');
		$need = isset($_POST['need'])?$_POST['need']:'';
		$cat_id = isset($_POST['cat_id'])?$_POST['cat_id']:'';
		$needModel = new MbNeedModel();
		$needModel->setNeed($need);
		$needModel->setId($id);
		$needModel->setCatId($cat_id);
		$needManager = new MbNeedManager();
		$needManager->_update($needModel);
		redirect(site_url('admin/addneed'));
	}	
		
	/**
	 * do add new category
	 * 
	 * @param
	 * 
	 */ 
	
	public function do_add_new_cat() {
		
		// $this->load->database();

		$this->load->model('mbcategorymanager');
		
		$this->load->model('mbcategorymodel');
		
		$categoryManager = new MBCategoryManager();
		
		$categoryModel = new MBCategoryModel();
		
		$name = isset($_POST['cat_name'])?$_POST['cat_name']:'';
		
		$parent_id = isset($_POST['cate_id'])?$_POST['cate_id']:'';
		
		$categoryModel->setName($name);
		
		$categoryModel->setParentId($parent_id);
		
		$categoryModel->setVisible(1);
		
		$categoryManager->insert($categoryModel);
		
		redirect(site_url('admin'));
	
	}
	
	/**
	 * 
	 * liet ke cac gian hang
	 * 
	 */
	
	public function gianhang() {
		$this->load->view("admin/header_admin.html");	
	}
	
	/**
	 * 
	 * liet ke cac tin rao vat
	 * 
	 */
	
	public function raovat($page=0) {
		$this->load->library('pagination');			
		$this->load->model('mbraovatmanager');
		$this->load->model('mbraovatmodel');
		$raovatManger = new MbRaoVatManager();
		$raovatModel = new MbRaoVatModel();
		$total = $raovatManger->getTotal();  //die($total);
		$config['base_url'] = site_url('admin/raovat'); 
                $config['total_rows'] = $total;       
                $config['per_page'] = '50';       
                $this->pagination->initialize($config);	
                $limit = $config['per_page'];
                //$offset = ($page - 1) * $limit;
                $paging = $this->pagination->create_links();
                $data['paging'] = $paging;
		$data['rv'] = $raovatManger->_selectSortByDate($limit,$page);	
		$this->load->view("admin/header_admin.html");	
		$this->load->view("admin/raovat_admin.html",$data);
	}
	
	/**
	 *  vi tri chung loai san pham 
	 * 
	 */
	
	public function catalogorder() {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$categoryModel->setParentId(0);
		$categoryModel->setVisible(1);
		$category = $categoryManager->_selectByPriority($categoryModel);
		$catid = isset($_POST['catid'])?$_POST['catid']:'';
		$order = isset($_POST['order'])?$_POST['order']:'';
		if (isset($order)&& $order!='') {
			foreach ($catid as $id) {
				$categoryManager->updatePriority($id, $order[$id]);
			}
		}		
		$this->load->view("admin/header_admin.html");		
		$this->load->view("admin/catalogorder.html",array('category'=>$category));
	}
	
	/**
	 *  vi tri rao vat 
	 * 
	 */
	
	public function raovatorder() {
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');
		$categoryManager = new MbCategoryManager();
		$categoryModel = new MbCategoryModel();
		$categoryModel->setParentId(0);
		$category = $categoryManager->_selectByOrder($categoryModel);
		$catid = isset($_POST['catid'])?$_POST['catid']:'';
		$order = isset($_POST['order'])?$_POST['order']:'';
		if (isset($order)&& $order!='') {
			foreach ($catid as $id) {
				$categoryManager->updateOrder($id, $order[$id]);
			}
		}				
		$this->load->view("admin/header_admin.html");		
		$this->load->view("admin/raovatorder.html",array('category'=>$category));
	}
	
	/**
	 *  xoa tin rao vat
	 * 
	 */
	
	public function removeraovat($id) {
		$this->load->model('mbraovatmanager');
		$this->load->model('mbraovatmodel');		
		$raovatManager = new MbRaovatManager();
		$raovatModel = new MbRaovatModel();
		$raovatModel->setId($id);
		$raovatManager->delete($raovatModel);
		redirect(site_url('admin/raovat'));		
	}
	
	/**
	 *  xoa hoi dap
	 * 
	 */
	
	public function removehoidap($id) {
		$this->load->model('mbquestionmanager');
		$this->load->model('mbquestionmodel');		
		$hoidapManager = new MbQuestionManager();
		$hoidapModel = new MbQuestionModel();
		$hoidapModel->setQid($id);
		$hoidapManager->delete($hoidapModel);
		redirect(site_url('admin/hoidap'));		
	}

	/**
	 *  xoa quang cao
	 * 
	 */
	
	public function removequangcao($id) {
		$this->load->model('mbadvmanager');
		$this->load->model('mbadvmodel');		
		$advManager = new MbAdvManager();
		$advModel = new MbAdvModel();
		$advModel->setId($id);
		$advManager->delete($advModel);
		redirect(site_url('admin/quangcao'));		
	}	
	/**
	 * 
	 * liet ke cac cau hoi
	 * 
	 */
	
	public function hoidap($page=0) {
		$this->load->library('pagination');		
		$this->load->model('mbquestionmanager');
		$this->load->model('mbquestionmodel');	
		$hoidapModel = new 	MbQuestionModel();
		$hoidapManager = new MbQuestionManager();
		$config['base_url'] = site_url('admin/hoidap'); 
		$total = $hoidapManager->getTotal();
                $config['total_rows'] = $total;       
                $config['per_page'] = '30';       
                $this->pagination->initialize($config);	
                $limit = $config['per_page'];	
		$data['hoidap'] = $hoidapManager->select($limit,$page);
                $paging = $this->pagination->create_links();
                $data['paging'] = $paging;        
		$this->load->view("admin/header_admin.html");
		$this->load->view("admin/hoidap_admin.html",$data);	
	}	
	
	/**
	 * 
	 * liet ke cac san pham
	 * 
	 */
	
	public function sanpham($catid='') {
		$this->load->view("admin/header_admin.html");
	}	
	
	
	/**
	 * liet ke cac quang cao
	 * 
	 */
	
	public function quangcao() {
		$this->load->model("mbadvmodel");
		$this->load->model("mbadvmanager");
		$this->load->view("admin/header_admin.html");
		$advManager = new MbAdvManager();
		$advModel = new MbAdvModel();
		$quangcao = $advManager->select();
		$this->load->view("admin/quangcao.html",array('quangcao'=>$quangcao));
	}
	
	/**
	 * dang quang cao
	 * 
	 */
	
	public function dangquangcao() {
		$this->load->model("mbadvmodel");
		$this->load->model("mbadvmanager");
		$img = $_POST['img_src'];
		$url = $_POST['img_url'];
		$tooltip = $_POST['img_text'];
		$order = $_POST['img_sort'];
		/* upload file */
		
		$target_path = "images/";

        $image_file_src = $target_path. basename( $_FILES['img_file_src']['name']);

        $target_path = $target_path . basename( $_FILES['img_file_src']['name']); 

        if (move_uploaded_file($_FILES['img_file_src']['tmp_name'],$target_path)) {

        }

        else{
            die("<font color='red'>There was an error uploading the file, please try again!</font>");
        }				
		
		$advManager = new MbAdvManager();
		$advModel = new MbAdvModel();
		if (isset($img) && $img!='') {
			$advModel->setImg($img);
		}
		else {
			$advModel->setImg($image_file_src);
		}
		$advModel->setUrl($url);
		$advModel->setToolTip($tooltip);
		$advModel->setOrder($order);
		$advManager->insert($advModel);
		redirect(site_url('admin/quangcao'));
	}
	
}



