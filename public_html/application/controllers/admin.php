<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
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
		$this->load->library('session');
		$account = $this->session->userdata('account');
		if (!$userManager->isLogin()) {
			redirect(site_url('login'));
		}
		if ($account!='admin' && $account!='hoangtn') {
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
	 * @author: truong
	 * category of news 
	 * 
	 */

	public function cat_news($page=0) {		
		$this->load->model('mbnewscatmanager');
		$this->load->model('mbnewscatmodel');
		$this->load->library('pagination');		
		$newscatManager = new MbNewsCatManager();
		$newscatModel = new MbNewsCatModel();		
		$this->load->view("admin/header_admin.html");
		$total = count($newscatManager->select($newscatModel));
		$config['total_rows'] = $total;   
                $config['per_page'] = '10';       
                $config['base_url'] = site_url('admin/cat_news');
                $this->pagination->initialize($config);	
                $limit = $config['per_page'];
                $paging = $this->pagination->create_links();        
                $data['paging'] = $paging;   		
		$limit = 10;
		$newscatModel->setParentId(0);
		$data['category'] = $newscatManager->selectByPage($newscatModel,$limit,$page);	
		foreach ($data['category'] as $value) {
			$cat_id = $value->getId();
			$newscatModel->setParentId($cat_id);
			$data['subcat'][$value->getId()] = $newscatManager->select($newscatModel);	
		}
		$this->load->view("admin/news_cat.html",$data);
	}
	
	/**
	 *  Add new category
	 * 
	 */
	
	public function addnewscat() {
		// $this->load->database();
		$this->load->model('mbnewscatmanager');
		$this->load->model('mbnewscatmodel');		
		$newscatManager = new MbNewsCatManager();
		$newscatModel = new MbNewsCatModel();
		// $categoryModel->setParentId(0);
		$data['category'] = $newscatManager->select($newscatModel);				
		$this->load->view("admin/header_admin.html");	
		$this->load->view("admin/addnewscat.html",$data);	
	} 
	

	
	/**
	 *  Edit a news category
	 * 
	 */
	
	public function editnewscat($id) {
		$this->load->model('mbnewscatmanager');
		$this->load->model('mbnewscatmodel');
		$newscatManager = new MbNewsCatManager();
		$newscatModel = new MbNewsCatModel();
		/* lay thong tin ve category */
		$newscatModel->setId($id);
		$result = $newscatManager->select($newscatModel);
		$data['cat'] = $result[0];
		/* lay danh muc goc */
		$newscatModel = new MbNewsCatModel();
		//$categoryModel->setParentId(0);
		$data['category'] = $newscatManager->select($newscatModel);	
		$data['cat_id'] = $id;
		$this->load->view("admin/header_admin.html");
		$this->load->view("admin/edit_newscat.html",$data);
	}
	
	/**
	 *  delete news category
	 * 
	 */
	
	public function deletenewscat($id) {
		$this->load->model('mbnewscatmanager');
		$this->load->model('mbnewscatmodel');
		$newscatManager = new MbNewsCatManager();
		$newscatModel = new MbNewsCatModel();
		$newscatModel->setId($id);
		$newscatManager->delete($newscatModel);
		redirect(site_url('admin/cat_news'));
	}	
	
	/**
	 *  set news category invisibly
	 * 
	 */
	
	public function setnewscat($id,$visible) {
		$this->load->model('mbnewscatmanager');
		$this->load->model('mbnewscatmodel');
		$newscatManager = new MbNewsCatManager();
		$newscatModel = new MbNewsCatModel();
		$newscatModel->setId($id);
		$newscatManager->visible($id,$visible);
		redirect(site_url('admin/cat_news'));
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
	
	public function do_add_newscat() {
		
		// $this->load->database();

		$this->load->model('mbnewscatmanager');
		
		$this->load->model('mbnewscatmodel');
		
		$newscatManager = new MbNewsCatManager();
		
		$newscatModel = new MbNewsCatModel();
		
		$name = isset($_POST['cat_name'])?$_POST['cat_name']:'';
		
		$parent_id = isset($_POST['cate_id'])?$_POST['cate_id']:'';
		
		$newscatModel->setName($name);
		
		$newscatModel->setParentId($parent_id);
		
		$newscatModel->setVisible(1);
		
		$newscatManager->insert($newscatModel);
		
		redirect(site_url('admin/cat_news'));
	
	}
	
	/**
	 *  edit news category
	 * 
	 */
	
	public function do_edit_newscat() {
		$id = isset($_POST['cat_id'])?$_POST['cat_id']:'';
		$this->load->model('mbnewscatmanager');
		$this->load->model('mbnewscatmodel');
		$name = isset($_POST['cat_name'])?$_POST['cat_name']:'';
		$parent_id = isset($_POST['parent_id'])?$_POST['parent_id']:'';
		$newscatModel = new MbNewsCatModel();
		$newscatModel->setName($name);
		$newscatModel->setId($id);
		$newscatModel->setParentId($parent_id);
		$newscatManager = new MbNewsCatManager();
		$newscatManager->update($newscatModel);
		redirect(site_url('admin/cat_news'));
	}
	
	/**
	 * 
	 * liet ke cac gian hang
	 * 
	 */
	
	public function gianhang($page=0) {
		$this->load->library('pagination');	
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$this->load->view("admin/header_admin.html");	
		$userModel = new MbUserModel();
		$userManager = new MbUserManager();				
		$result =$userManager->selectStore();		
		$config['base_url'] = site_url('admin/gianhang');		
		$total = count($result);				
                $config['total_rows'] = $total;       
                $config['per_page'] = '50';       
                $this->pagination->initialize($config);	
                $limit = $config['per_page'];
                $paging = $this->pagination->create_links();				
		$data['paging']=$paging;
		$data['gianhang'] =  $userManager->selectStoreByPage($limit, $page);		
		$this->load->view("admin/gianhang.html",$data);
	}
	
	/**
	 * 
	 * liet ke cac thanh vien
	 * 
	 */
	
	public function member($page=0) {
		$this->load->library('pagination');	
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$this->load->view("admin/header_admin.html");	
		$userModel = new MbUserModel();
		$userManager = new MbUserManager();				
		$result =$userManager->select($userModel);		
		$config['base_url'] = site_url('admin/member');		
		$total = count($result);				
                $config['total_rows'] = $total;       
                $config['per_page'] = '500';       
                $this->pagination->initialize($config);	
                $limit = $config['per_page'];
                $paging = $this->pagination->create_links();				
		$data['paging']=$paging;
		$data['gianhang'] =  $userManager->selectByPage($userModel,$limit, $page);		
		$this->load->view("admin/thanhvien.html",$data);
	}	
	
	public function thongbao() {
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$this->load->view("admin/header_admin.html");	
		$userModel = new MbUserModel();
		$userManager = new MbUserManager();				
		$result =$userManager->select($userModel);
		include 'mailer.php';

		foreach ($result as $value) {
			$to = $value->getEmail();
			//var_dump($result);
			$subject = 'Thong bao thay doi ten mien website http://muarenhat.net -> http://muarenhat.vn';
			//$msg = 'Ngay dang tin: '.$date.'<br>';
			//$msg .= 'Noi dung tin: <br>'.$content;
			$msg = 'Xin chào các thành viên của trang web muarenhat.net,<br><br>

Đầu tiên thay mặt Ban quản trị website, Tôi xin gửi lời cảm ơn tới tất cả các thành viên đã tham gia web muarenhat.net trong suốt mấy năm vừa qua!<br><br>

Do nhu cầu đăng tin rao vặt miễn phí rất lớn, để cho thân thiện với thị trường Việt Nam hơn và dễ nhớ hơn, nên ban quản trị quyết đinh thay đổi tên miền muarenhat.net thành tên miền muarenhat.vn từ ngày 18/7/2016<br><br>
Từ ngày 19/7/2016, các thành viên có thể truy cập website http://muarenhat.vn để đăng tin rao vặt Miễn phí.<br><br>
Tên truy cập và mật khẩu của các thành viên của web muarenhat.net sau khi chuyễn sang muarenhat.vn vẫn giữ nguyên như cũ<br><br>
Xin trân trọng thông báo để các bạn thành viên website được biết<br><br>
Mọi thông tin cần hỗ trợ các bạn liên lạc với Ban Quản trị<br><br>
Mr. Nguyễn Mạnh Trường<br><br>
ĐT: 04.35561511<br><br>
Xin trân trọng cảm ơn!<br><br>
P/s:Email được gửi tự động từ hệ thống.
';
			// send mail to sonlocdien@gmail.com
			smtpmailer($to, 'muarenhatvn.mailer@gmail.com', 'Mua Re Nhat', $subject, $msg);
			echo 'sent email to: '.$to.'<br>';
		}
		//var_dump($result);
		        $subject = 'Tin dang moi muarenhat.vn -'.$subject;
        //$msg = 'Ngay dang tin: '.$date.'<br>';
        //$msg .= 'Noi dung tin: <br>'.$content;
		$msg = '';
        // send mail to sonlocdien@gmail.com
        //smtpmailer('muarenhatvn.mailer@gmail.com', 'muarenhatvn.mailer@gmail.com', 'Mua Re Nhat', $subject, $msg);
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
	
	public function slider($id=0) {
		$this->load->model("mbslidermodel");
		$this->load->model("mbslidermanager");
		$this->load->view("admin/header_admin.html");
		$sliderManager = new MbSliderManager();
		$sliderModel = new MbSliderModel();
		$quangcao = $sliderManager->select($sliderModel);
		$id = intval($id);
		if ($id!=0) {
			$sliderModel->setId($id);
			$qcinfo = $sliderManager->select($sliderModel);
		}
		else {
			$qcinfo[0]= new MbSliderModel();
		}
		$this->load->view("admin/slider.html",array('quangcao'=>$quangcao,"qcinfo"=>$qcinfo[0]));		
		//$this->load->view("admin/slider.html");
	}
	
	/**
	 *  vi tri chung loai san pham 
	 * 
	 */
	
	public function catalog() {
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
		$this->load->view("admin/catalog.html",array('category'=>$category));
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
	 *  tam khoa gian hang
	 * 
	 */
	
	public function inactiveuser($id,$type=0) {
		$this->load->model('mbusermanager');
		$this->load->model('mbusermodel');		
		$userManager = new MbUserManager();
		//$userModel = new MbUserModel();
		//$userModel->setId($id);
		$id = intval($id);
		$userManager->setactive($id,0);
		if ($type==0) {
			redirect(site_url('admin/gianhang'));
		}		
		if ($type==1) {
			redirect(site_url('admin/member'));
		}
	}

	/**
	 *  tam khoa gian hang
	 * 
	 */
	
	public function activeuser($id,$type=0) {
		$this->load->model('mbusermanager');
		$this->load->model('mbusermodel');		
		$userManager = new MbUserManager();
		$id = intval($id);
		$userManager->setactive($id,1);
		// redirect(site_url('admin/gianhang'));	
		if ($type==0) {
			redirect(site_url('admin/gianhang'));
		}		
		if ($type==1) {
			redirect(site_url('admin/member'));
		}			
	}	
	
	public function activehome($id) {
		$sql = "UPDATE mb_category SET home_=1 WHERE id_=".$id;
		$this->db->query($sql);
		redirect(site_url('admin/catalog'));
	}
	
	public function inactivehome($id) {
		$sql = "UPDATE mb_category SET home_=0 WHERE id_=".$id;
		$this->db->query($sql);
		redirect(site_url('admin/catalog'));
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
	 *  xoa slider
	 * 
	 */
	
	public function removeslider($id) {
		$this->load->model('mbslidermanager');
		$this->load->model('mbslidermodel');		
		$sliderManager = new MbSliderManager();
		$sliderModel = new MbSliderModel();
		$sliderModel->setId($id);
		$sliderManager->delete($sliderModel);
		redirect(site_url('admin/slider'));		
	}	
	
	/**
	 *  xoa link
	 * 
	 */
	
	public function removelink($id) {
		$this->load->model('mblinkmanager');
		$this->load->model('mblinkmodel');		
		$linkManager = new MbLinkManager();
		$linkModel = new MbLinkModel();
		$linkModel->setId($id);
		$linkManager->delete($linkModel);
		redirect(site_url('admin/link'));		
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
	 *  xoa tin
	 * 
	 */
	
	public function removetin($id) {
		$this->load->model('mbtintucmanager');
		$this->load->model('mbtintucmodel');		
		$tintucManager = new MbTinTucManager();
		$tintucModel = new MbTinTucModel();
		$tintucModel->setId($id);
		$tintucManager->delete($tintucModel);
		redirect(site_url('admin/tintuc'));		
	}	
	
	/**
	 *  xoa video
	 * 
	 */
	
	public function removevideo($id) {
		$this->load->model('mbvideomanager');
		$this->load->model('mbvideomodel');		
		$videoManager = new MbVideoManager();
		$videoModel = new MbVideoModel();
		$videoModel->setId($id);
		$videoManager->delete($videoModel);
		redirect(site_url('admin/video'));		
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
	
	public function sanpham($page=0) {
		$this->load->view("admin/header_admin.html");
		$this->load->model('mbcategorymanager');
		$this->load->model('mbcategorymodel');		
		$categoryManager = new MBCategoryManager();
		$categoryModel = new MBCategoryModel();
		//$categoryModel->setParentId(0);
		$data['category'] = $categoryManager->select($categoryModel);				
		$this->load->model("mbproductmodel");
		$this->load->model("mbproductmanager");
		$productManager = new MbProductManager();
		$productModel = new MbProductModel();
		$keyword=isset($_POST['keyword'])?$_POST['keyword']:'';
		$category=isset($_POST['cate_id'])?$_POST['cate_id']:'';
		if ($keyword!='') {
			$productModel->setName($keyword);
		}
		if ($category!=0) {
			$productModel->setCategory($category);
		}
		$data['product'] = $productManager->select($productModel);
		$total = count($data['product']);
		$this->load->library('pagination');	        
        $config['base_url'] = site_url('admin/sanpham');
		$config['total_rows'] = $total; 
		$config['uri_segment'] = 3;
        $config['per_page'] = '20';       
        $this->pagination->initialize($config);	
        $limit = $config['per_page'];
        $paging = $this->pagination->create_links(); //print_r($paging); //die;
        $data['paging'] = $paging;	
        $data['product'] = $productManager->selectByPage($productModel, $limit, $page);	
		$this->load->view("admin_product.html",$data);
	}	

	/**
	 * liet ke cac quang cao
	 * 
	 */
	
	public function link($id=0) {
		$this->load->model("mblinkmodel");
		$this->load->model("mblinkmanager");
		$this->load->view("admin/header_admin.html");
		$linkManager = new MbLinkManager();
		$linkModel = new MbLinkModel();
		$link = $linkManager->select($linkModel);
		$id = intval($id);
		if ($id!=0) {
			$linkModel->setId($id);
			$linkinfo = $linkManager->select($linkModel);
		}
		else {
			$linkinfo[0]= new MbLinkModel();
		}
		$this->load->view("admin/link.html",array('link'=>$link,"linkinfo"=>$linkinfo[0]));
	}	
	
	/**
	 * liet ke cac quang cao
	 * 
	 */
	
	public function quangcao($id=0) {
		$this->load->model("mbadvmodel");
		$this->load->model("mbadvmanager");
		$this->load->view("admin/header_admin.html");
		$advManager = new MbAdvManager();
		$advModel = new MbAdvModel();
		$quangcao = $advManager->select($advModel);
		$id = intval($id);
		if ($id!=0) {
			$advModel->setId($id);
			$qcinfo = $advManager->select($advModel);
		}
		else {
			$qcinfo[0]= new MbAdvModel();
		}
		$this->load->view("admin/quangcao.html",array('quangcao'=>$quangcao,"qcinfo"=>$qcinfo[0]));
	}
	
	/**
	 * tin tuc
	 * 
	 */
	
	public function tintuc($id=0) {
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$id = intval($id);
		$tintucModel = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();		
		if ($id!=0) {
			$tintucModel->setId($id);
			$tintucinfo = $tintucManager->select($tintucModel);
		}
		else {
			$tintucinfo[0]= new MbTinTucModel();
		}		
		$data['tin'] = $tintucManager->select($tintucModel);
		$data['tintucinfo'] = $tintucinfo[0];
		//print_r($data['tin']);
		$this->load->model('mbnewscatmanager');
		$this->load->model('mbnewscatmodel');
		$newscatManager = new MbNewsCatManager();
		$newscatModel = new MbNewsCatModel();		
		$data['newscat'] = $newscatManager->select($newscatModel);
		$this->load->view("admin/header_admin.html");
		$this->load->view("admin/tintuc.html",$data);		
	}
	/** 
	 * video 
	 * 
	 */
	 
	public function video($id=0) {
		$this->load->model("mbvideomodel");
		$this->load->model("mbvideomanager");
		$id = intval($id);
		$videoModel = new MbVideoModel();
		$videoManager = new MbVideoManager();		
		if ($id!=0) {
			$videoModel->setId($id);
			$videoinfo = $videoManager->select($videoModel);
		}
		else {
			$videoinfo[0]= new MbVideoModel();
		}		
		$data['video'] = $videoManager->select($videoModel);
		$data['videoinfo'] = $videoinfo[0];
		//print_r($data['tin']);
		/*
		$this->load->model('mbvideocatmanager');
		$this->load->model('mbvideocatmodel');
		$videocatManager = new MbVideoCatManager();
		$videocatModel = new MbVideoCatModel();		
		$data['videocat'] = $newscatManager->select($newscatModel);*/
		$this->load->view("admin/header_admin.html");
		$this->load->view("admin/video.html",$data);		
	}	
	
	public function baocaosms() {
		$sql = "SELECT * FROM mb_smslog ORDER BY datelog DESC";
		$query = $this->db->query($sql);
		$data['sms'] = $query->result();
		$this->load->view("admin/header_admin.html");
		$this->load->view("admin/baocaosms.html",$data);	
	}
	
	/**
	 * dang tin
	 * 
	 */
	
	public function dangtin() {
		$this->load->model("mbtintucmodel");
		$this->load->model("mbtintucmanager");
		$title = $_POST['title'];
		$url = $_POST['url'];
		$img = $_POST['img_src'];
		$summary = $_POST['summary'];
		$news_detail = $_POST['news_detail'];
		$order = $_POST['sort'];
		$cat = $_POST['cat'];
		
		/* upload file */
		
		$target_path = "images/";

        $image_file_src = $target_path. basename( $_FILES['img_file_src']['name']);

        $target_path = $target_path . basename( $_FILES['img_file_src']['name']); 
        if ($_POST['id']=='' || $img!='') {
	        if ($img=='' || $_FILES['img_file_src']['tmp_name']!='') {
	
		        if (move_uploaded_file($_FILES['img_file_src']['tmp_name'],$target_path)) {
		
		        }
		        else{
		            die("<font color='red'>There was an error uploading the file, please try again!</font>");
		        }
	        }				
        }
		
		$tintucModel = new MbTinTucModel();
		$tintucManager = new MbTinTucManager();
		if ($_FILES['img_file_src']['tmp_name']!='') {
			$tintucModel->setImg($image_file_src);
		}
		else
		if (isset($img) && $img!='') {
			$tintucModel->setImg($img);
		}
		else {
			$tintucModel->setImg($image_file_src);
		}		
		$tintucModel->setUrl($url);
		$tintucModel->setTitle($title);
		$tintucModel->setSummary($summary);
		$tintucModel->setDetail($news_detail);
		$tintucModel->setPriority($order);
		$tintucModel->setCat($cat);
		$date = date("Y-m-d H:i:s");
		$tintucModel->setDate($date);
		$id = $_POST['id'];
		if ($id=='') {
			$tintucManager->insert($tintucModel);
		}
		else {
			$tintucModel->setId($id);
			$tintucManager->update($tintucModel);
		}
		redirect(site_url('admin/tintuc'));		
	} 
	
	/**
	 * dang video
	 * 
	 */
	
	public function dangvideo() {
		$this->load->model("mbvideomodel");
		$this->load->model("mbvideomanager");
		$title = $_POST['title'];
		$url = $_POST['url'];
		$img = $_POST['img_src'];
		$summary = $_POST['summary'];
		//$news_detail = $_POST['news_detail'];
		//$order = $_POST['sort'];
		//$cat = $_POST['cat'];
		
		/* upload file */
		/*
		$target_path = "images/";

        $image_file_src = $target_path. basename( $_FILES['img_file_src']['name']);

        $target_path = $target_path . basename( $_FILES['img_file_src']['name']); 
        if ($_POST['id']=='' || $img!='') {
	        if ($img=='' || $_FILES['img_file_src']['tmp_name']!='') {
	
		        if (move_uploaded_file($_FILES['img_file_src']['tmp_name'],$target_path)) {
		
		        }
		        else{
		            die("<font color='red'>There was an error uploading the file, please try again!</font>");
		        }
	        }				
        }
		*/
		$videoModel = new MbVideoModel();
		$videoManager = new MbVideoManager();
		/*
		if ($_FILES['img_file_src']['tmp_name']!='') {
			$tintucModel->setImg($image_file_src);
		}
		else
		if (isset($img) && $img!='') {
			$tintucModel->setImg($img);
		}
		else {
			$tintucModel->setImg($image_file_src);
		}		
		*/
		$videoModel->setTitle($title);
		$videoModel->setDescription($summary);
		$videoModel->setYoutubeId($url);
		$videoModel->setThumbnail($img);
		/*$videoModel->setPriority($order);
		$videoModel->setCat($cat);*/
		$date = date("Y-m-d H:i:s");
		$videoModel->setPublishDate($date);
		$id = $_POST['id'];
		if ($id=='') {
			$videoManager->insert($videoModel);
		}
		else {
			$videoModel->setId($id);
			$videoManager->update($videoModel);
		}
		redirect(site_url('admin/video'));		
	} 
	
	
	/**
	 * dang link
	 * 
	 */
	
	public function addlink() {
		$this->load->model("mblinkmodel");
		$this->load->model("mblinkmanager");
		$url = $_POST['img_url'];
		$textlink = $_POST['img_text'];
		$title = $_POST['title'];		
		$linkManager = new MbLinkManager();
		$linkModel = new MbLinkModel();
		$linkModel->setUrl($url);
		$linkModel->setTextlink($textlink);
		$linkModel->setTitle($title);
		$id = $_POST['id'];
		if ($id=='') {
			$linkManager->insert($linkModel);
		}
		else {
			$linkModel->setId($id);
			$linkManager->update($linkModel);
		}
		redirect(site_url('admin/link'));
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
		$title = $_POST['title'];
		$home = isset($_POST['home'])?$_POST['home']:0;
		$raovat = isset($_POST['raovat'])?$_POST['raovat']:0;
		if ($home) {
			$home=1;
		}
		if ($raovat) {
			$raovat=1;
		}
		/* upload file */
		
		$target_path = "images/";

        $image_file_src = $target_path. basename( $_FILES['img_file_src']['name']);

        $target_path = $target_path . basename( $_FILES['img_file_src']['name']); 
        
        if ($img=='' || $_FILES['img_file_src']['tmp_name']!='') {

        if (move_uploaded_file($_FILES['img_file_src']['tmp_name'],$target_path)) {

        }

        else{
            die("<font color='red'>There was an error uploading the file, please try again!</font>");
        }				
        
        }
		
		$advManager = new MbAdvManager();
		$advModel = new MbAdvModel();
		if ($_FILES['img_file_src']['tmp_name']!='') {
			$advModel->setImg($image_file_src);
		}
		else
		if (isset($img) && $img!='') {
			$advModel->setImg($img);
		}
		else {
			$advModel->setImg($image_file_src);
		}
		$advModel->setUrl($url);
		$advModel->setToolTip($tooltip);
		$advModel->setOrder($order);
		$advModel->setTitle($title);
		$advModel->setHome($home);
		$advModel->setRaovat($raovat);
		$id = $_POST['id'];
		if ($id=='') {
			$advManager->insert($advModel);
		}
		else {
			$advModel->setId($id);
			$advManager->update($advModel);
		}
		redirect(site_url('admin/quangcao'));
	}
	
	public function updateslider() {
		$this->load->model("mbslidermodel");
		$this->load->model("mbslidermanager");
		$img = $_POST['img_src'];
		$url = $_POST['img_url'];
		$tooltip = $_POST['img_text'];
		$order = $_POST['img_sort'];
		$title = $_POST['title'];
		/* upload file */
		
		$target_path = "images/";

        $image_file_src = $target_path. basename( $_FILES['img_file_src']['name']);

        $target_path = $target_path . basename( $_FILES['img_file_src']['name']); 
        
        if ($img=='' || $_FILES['img_file_src']['tmp_name']!='') {

        if (move_uploaded_file($_FILES['img_file_src']['tmp_name'],$target_path)) {

        }

        else{
            die("<font color='red'>There was an error uploading the file, please try again!</font>");
        }				
        
        }
		
		$sliderManager = new MbSliderManager();
		$sliderModel = new MbSliderModel();
		if ($_FILES['img_file_src']['tmp_name']!='') {
			$sliderModel->setImg($image_file_src);
		}
		else
		if (isset($img) && $img!='') {
			$sliderModel->setImg($img);
		}
		else {
			$sliderModel->setImg($image_file_src);
		}
		$sliderModel->setUrl($url);
		$sliderModel->setToolTip($tooltip);
		$sliderModel->setOrder($order);
		$sliderModel->setTitle($title);
		$id = $_POST['id'];
		if ($id=='') {
			$sliderManager->insert($sliderModel);
		}
		else {
			$sliderModel->setId($id);
			$sliderManager->update($sliderModel);
		}
		redirect(site_url('admin/slider'));
		
	}
	
	// liet ke danh sach don hang
	
	public function order() {
		$sql = "SELECT * FROM mb_user u join mb_order o on u.id_=o.user_id_ ORDER BY o.status_,o.order_date_ DESC";
		$query = $this->db->query($sql);
		$result = $query->result();
		$data['order'] = $result;
		//print_r($result); die;
		$this->load->view("admin/header_admin.html");
		$this->load->view("admin/listorder.html",$data);
	}
	
	// chi tiet don hang
	
	public function orderdetail($order_id) {	
		if (isset($_POST['cmd'])) {
			$sql = "UPDATE mb_order SET status_='".$_POST['status']."' WHERE id_=".$order_id;
			$this->db->query($sql);
			redirect(site_url('admin/order'));
		}	
		$sql = "SELECT * FROM mb_user u join mb_order o on u.id_=o.user_id_ WHERE o.id_=$order_id ORDER BY o.order_date_ DESC";
		$query = $this->db->query($sql);
		$result = $query->result();
		$data['order'] = $result;
		$sql = "SELECT * FROM mb_order_product op join mb_order o on op.order_id_=o.id_ join mb_product p on p.id_=op.product_id_ WHERE o.id_=$order_id ORDER BY o.order_date_ DESC";
		$query = $this->db->query($sql);
		$result = $query->result();
		$data['order_detail'] = $result;	
		$this->load->view("admin/header_admin.html");
		// print_r($data['order_detail']);
		$this->load->view("admin/orderdetail.html",$data);			
	}
	
	// quan tri noi dung trang web
	
	public function content($id=0) {
		
		$this->load->model("mbcontentmodel");
		
		$this->load->model("mbcontentmanager");
		
		$this->load->view("admin/header_admin.html");
		
		$contentManager = new MbContentManager();
		
		$contentModel = new MbContentModel();
				
		if ($id!=0) {
			$contentModel->setId($id);
			$contentinfo = $contentManager->select($contentModel);
		}
		else {
			$contentinfo[0]= new MbContentModel();
		}		
			
		//print_r($contentinfo); die;
		
		$data['content'] = $contentinfo;
		
		
		$tin = $contentManager->select($contentModel);
		
		$data['tin'] = $tin;
				
		$this->load->view("admin/content.html",$data);
		
	}
	
	public function newcontent() {
		$this->load->model("mbcontentmodel");
		$this->load->model("mbcontentmanager");
		$title = $_POST['title'];
		$content = $_POST['content'];
		// $cat = $_POST['cat'];
		$contentModel = new MbContentModel();
		$contentManager = new MbContentManager();
		$contentModel->setTitle($title);
		$contentModel->setContent($content);
		// $contentModel->setCat($cat);
		$date = date("Y-m-d H:i:s");
		$contentModel->setDate($date);
		$id = $_POST['id'];
		if ($id=='') {
			$contentManager->insert($contentModel);
		}
		else {
			$contentModel->setId($id);
			$contentManager->update($contentModel);
		}
		redirect(site_url('admin/content'));						
	}
	
		/**
	 *  xoa noi dung
	 * 
	 */
	
	public function removecontent($id) {
		$this->load->model('mbcontentmanager');
		$this->load->model('mbcontentmodel');		
		$contentManager = new MbContentManager();
		$contentModel = new MbContentModel();
		$contentModel->setId($id);
		$contentManager->delete($contentModel);
		redirect(site_url('admin/content'));		
	}	
	
}


