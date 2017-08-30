<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sanpham extends CI_Controller {
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
	 
	public function index()
	{
		$this->loadHeader();
		$this->load->view("sanpham.html");
		$this->loadFooter();
	}
	
	/**
	 * sua thong tin san pham
	 * 
	 */
	
	public function do_edit_product() {
		$this->load->model("mbproductmodel");		
		$this->load->model("mbproductmanager");
		$image_path = $_POST['uploadfile'];
		$store_cat_id = isset($_POST['store_cat_id'])?$_POST['store_cat_id']:'';
		$name = isset($_POST['pro_name'])?$_POST['pro_name']:'';
        $price = isset($_POST['price'])?$_POST['price']:'';
        $price = isset($_POST['sale_price'])?$_POST['sale_price']:$price;
        $price = str_replace(",","",$price);
        $price = str_replace(".","",$price);
        $price = intval($price);
        $category = isset($_POST['cat_id'])?$_POST['cat_id']:'';
        $userid = isset($_POST['user_id'])?$_POST['user_id']:'';
        $description = isset($_POST['pro_desc'])?$_POST['pro_desc']:'';
        $technicalDescription = isset($_POST['technical_desc'])?$_POST['technical_desc']:'';
        $date_create = date("Y-m-d H:i:s");	
        $image_default_old = isset($_POST['image_default'])?$_POST['image_default']:'';        
        $imageArray = $this->createthumbnail();		
        $image_default_new = $imageArray['image_default'];	
		if ($image_default_new!='') {		
			$image_default	= $image_default_new;
			$image_thumbnail = $imageArray['image_thumbnail'];
		}
		else {
			$image_thumbnail = $_POST['image_thumbnail_'];
			$image_default	= $image_default_old;
		}
		$p_id = isset($_POST['p_id'])?$_POST['p_id']:'';
        $productManager = new MbProductManager();
        $productModel = new MbProductModel();
        $productModel->setId($p_id);
        $productModel->setName($name);
        $productModel->setPrice($price);
        $productModel->setDescription($description);
        $productModel->setCategory($category);
        $productModel->setImageDefault($image_default);
        if (isset($image_thumbnail)) {
        	$productModel->setImageThumbNail($image_thumbnail);
        }
        $productModel->setStoreCatId($store_cat_id);
        $productModel->setStatus(1);
        $productModel->setTechnicalDescription($technicalDescription);
        $productModel->setUserId($userid);
        $productModel->setDate($date_create);
        $productManager->update($productModel);
		redirect(site_url('admin/sanpham'));
	}
	
	/**
	 *  Them san pham moi
	 *  @author: truong
	 * 
	 */
	
	public function do_add_new_product() {	
	    
		$this->load->model("mbproductmodel");
		
		$this->load->model("mbproductmanager");
		
		$image_path = $_POST['uploadfile'];
		
		$image_default = isset($_POST['image_default'])?$_POST['image_default']:'';
		
		$imageArray = $this->createThumbnail();
		
		if ($image_default=='') {
		
			$image_default = $imageArray['image_default'];
		
		}
		
		$image_thumbnail = $imageArray['image_thumbnail'];
		$store_cat_id = isset($_POST['store_cat_id'])?$_POST['store_cat_id']:'';
        $name = isset($_POST['pro_name'])?$_POST['pro_name']:'';
        $price = isset($_POST['price'])?$_POST['price']:'';
        $price = isset($_POST['sale_price'])?$_POST['sale_price']:$price;
        $price = str_replace(",","",$price);
        $price = str_replace(".","",$price);
        $price = intval($price);
        $category = isset($_POST['cat_id'])?$_POST['cat_id']:'';
        $userid = isset($_POST['user_id'])?$_POST['user_id']:'';
        $description = isset($_POST['pro_desc'])?$_POST['pro_desc']:'';
        $technicalDescription = isset($_POST['technical_desc'])?$_POST['technical_desc']:'';
        $date_create = date("Y-m-d H:i:s");
        $productManager = new MbProductManager();
        $productModel = new MbProductModel();
        $productModel->setName($name);
        $productModel->setPrice($price);
        $productModel->setDescription($description);
        $productModel->setCategory($category);
        $productModel->setImageDefault($image_default);
        $productModel->setImageThumbNail($image_thumbnail);
        $productModel->setImagePath($image_path);
        $productModel->setStatus(1);
        $productModel->setTechnicalDescription($technicalDescription);
        $productModel->setUserId($userid);
        $productModel->setDate($date_create);
        $productModel->setStoreCatId($store_cat_id);
        $productManager->insert($productModel);
        
		redirect(site_url('admin/sanpham'));
	}
	
	public function remove() {
		$id = $_POST['id'];
		$key = $_POST['key'];
		$valid_key = sha1('muaban!2');
		if ($key==$valid_key) {
			$this->db->where('id_', $id);
			$this->db->delete("mb_product");
		}
	}
	
	function createThumbnail() {
		$final_height_of_image = 100;
		//$final_width_of_image = 100;  
		$path_to_image_directory = 'images/fullsized/';  
		$path_to_thumbs_directory = 'images/thumbs/'; 
		
		if(isset($_FILES['upload'])) {
		
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['upload']['name'])) {
				$key = mktime();
				$filename = $key.str_replace(" ","", $_FILES['upload']['name']);
				$source = $_FILES['upload']['tmp_name'];
				$target = $path_to_image_directory . $filename;
				if (move_uploaded_file($source, $target)) {
		        /*  
				//createThumbnail($filename);					
			
				if(preg_match('/[.](jpg)$/', $filename)) {
					$im = imagecreatefromjpeg($path_to_image_directory . $filename);
				} else if (preg_match('/[.](gif)$/', $filename)) {
					$im = imagecreatefromgif($path_to_image_directory . $filename);
				} else if (preg_match('/[.](png)$/', $filename)) {
					$im = imagecreatefrompng($path_to_image_directory . $filename);
				}
			
				$ox = imagesx($im);
				$oy = imagesy($im);
			
				//$nx = $final_width_of_image;
				//$ny = floor($oy * ($final_width_of_image / $ox));
				
				$ny = $final_height_of_image; 
				
				$nx = floor($ox * ($ny / $oy));
			
				$nm = imagecreatetruecolor($nx, $ny);
			
				imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
			
				if(!file_exists($path_to_thumbs_directory)) {
				  if(!mkdir($path_to_thumbs_directory)) {
			           die("There was a problem. Please try again!");
				  }
			    }			
				imagejpeg($nm, $path_to_thumbs_directory . $filename);
				//$tn = '<img src="' . $path_to_thumbs_directory . $filename . '" alt="image" />';
				//$tn .= '<br />Congratulations. Your file has been successfully uploaded, and a 	  thumbnail has been created.';
				//echo $tn;*/				
				$uploaddir = $path_to_thumbs_directory;
				$uploadfile = $uploaddir . $key . basename($_FILES['upload']['name']);
				$filename = $key.$_FILES['upload']['name'];
				$size = $_FILES['upload']['size'];
				$file = $path_to_image_directory.$filename;	
				$newfile = 	$path_to_thumbs_directory . $filename;		
				//if($_FILES['upload']['type'] == "image/jpeg" || $_FILES['upload']['type'] == "image/png" || $_FILES['upload']['type'] == "image/gif") {
				//if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile)) {
				if (file_exists($newfile)) {
					unlink($newfile);
				}
				if (copy($file, $newfile)) {
					$token="lessbit";
					$resize="100x100";				
					$url_api = "http://api-vn.visqua.com";
									
				/*------------------------------VisQua API -----------------------------*/
				
				//$this->visqua_compress($url_api,$token,$newfile,$resize,1); //default 1: archive original file					
				
				/*------------------------------VisQua API End---------------------------*/
				} else {
				   //echo "Upload failed \n";
				}
				$image_default = $path_to_image_directory.$filename;
				$thumbnail = $path_to_thumbs_directory . $filename;
				return array('image_default'=>$image_default,'image_thumbnail'=>$thumbnail);

				}
			}
		}				
	}
	

	/** 
	 * sua san pham
	 * 
	 */
	
	public function edit($pid) {
		$pid=intval($pid);
		$sql = "SELECT p.store_cat_id,p.id_,p.name_,p.price_,p.image_default_,p.image_thumbnail_,p.description_,p.technical_description_,p.user_id_,p.category_ FROM mb_product p WHERE id_=".$pid;
		$query = $this->db->query($sql);
		$result = $query->result();
		if (count($result)>0) {			
			$product = $result[0]; 
			$data['product']=$product;	
			$data['p_id']=$pid;
			$this->load->view("admin/header_admin.html");
			$this->load->view("editproduct.html",$data);
		}		
	}
	
	/**
	 *  Dang san pham
	 *  @author: truong
	 */
	
	public function dangsanpham($step=0,$cat_id=0) {
		// kiem tra xem da dang ky gian hang chua?
		$this->load->library('session');
		$account = $this->session->userdata('account');	
		$this->load->view("admin/header_admin.html");
		$this->load->view("add_product.html");
		// $this->loadFooter();
	}
	
	public function getUserId() {
		$this->load->library('session');
		$account = $this->session->userdata('account');
		if (empty($account)) return;
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$userModel = new MbUserModel();
		$userModel->setAccount($account);
		$userManager = new MbUserManager();
		$userInfo = $userManager->select($userModel);
		if (count($userInfo)>0) {
			return $userInfo[0]->getId();
		}
		return ;
	}
	
	/**
	 * Load header
	 * @author: truong
	 */
	
	public function loadHeader() {
		/* SEO */
		$this->load->model('mbseomodel');
		$this->load->model('mbseomanager');
		$seoManager = new MbSeoManager();
		$url = site_url('sanpham');		
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
			$this->load->view('header.html',$data);
		}
		else {		
			$this->load->view('header.html',$data);
		}		
	}
	
	public function loadFooter() {
		$sql = "SELECT * FROM mb_sys";
		$query = $this->db->query($sql);
		$result = $query->result();
		$data['footer'] = $result[0];
		$this->load->view('footer.html',$data);
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
	public function visqua_compress($url,$token,$uploadfile,$resize,$archive='1')
	{
			if ($archive == 1){		
				copy($uploadfile,$uploadfile.'.visqua');
			}
			else {
				unlink($uploadfile.'.visqua');		
			}			
			$file_visqua = fopen($uploadfile.'.tmp.visqua', 'w');
		 	$ch = curl_init($url);
	        	curl_setopt($ch, CURLOPT_POST, 1);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        	curl_setopt($ch, CURLOPT_FILE, $file_visqua);
	        	curl_setopt($ch, CURLOPT_POSTFIELDS, array ('userfile'=>"@$uploadfile", 'token'=>"$token", 'resize'=>"$resize"));
			curl_setopt($ch, CURLOPT_HEADER, 0); 
		        $postResult = curl_exec($ch);
			$status=curl_getinfo($ch, CURLINFO_HTTP_CODE);
		        curl_close($ch);
	        	fclose($file_visqua);
	        if (($status == 200)){
				unlink($uploadfile);
				rename($uploadfile.'.tmp.visqua', $uploadfile);        
	        }
	        else {
				unlink($uploadfile.'.tmp.visqua');
	        }
	}	
}