<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller {

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
	 *  checkout
	 * 
	 */
	
	function __construct()
	{
		parent::__construct();
		//session_start();
		$this->load->model('mbusermanager');
		$this->load->model('mbusermanager');
		$userManager = new MbUserManager();
		if (!$userManager->isLogin()) {
			redirect(site_url('login'));
		}		
	}	
	
	public function index()
	{  		
		//session_start();
		$this->load->library('session');
		$account = $this->session->userdata('account');
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$userModel = new MbUserModel();
		$userModel->setAccount($account);
		$userManager = new MbUserManager();
		$result = $userManager->select($userModel);
		$user = new MbUserModel();
		if (count($result)>0) {
			$user=$result[0];
		}		
		$data['user'] = $user;
		$this->loadHeader();
		$cart_data = $this->getCart();
		//print_r($cart_data);		
		$data['total'] = $cart_data['total'];
		$this->load->view("checkout.html",$data);
		$this->load->view("footer.html");
		//echo 111;
	}
	
	public function completed() {
		require('mailer.php');
		session_start();
		// gui mail cho nguoi dat hang
		$order_id = $_SESSION['orderid'];
		$sql = "SELECT * FROM mb_user u join mb_order o on u.id_=o.user_id_ WHERE o.id_=$order_id ORDER BY o.order_date_ DESC";
		$query = $this->db->query($sql);
		$result = $query->result();
		$order = $result[0];
		$sql = "SELECT * FROM mb_order_product op join mb_order o on op.order_id_=o.id_ join mb_product p on p.id_=op.product_id_ WHERE o.id_=$order_id ORDER BY o.order_date_ DESC";
		$query = $this->db->query($sql);
		$result = $query->result();
		$order_detail = $result;			
		// print_r($order); die;
		$html = '';
		$html.= "<h1>Xác nhận đơn hàng</h1>

				Kính chào quý khách $order->name_,<br>

				Xin chân thành cám ơn quý khách mua sắm tại muarenhat.net.<br> Hi vọng quý khách đã có khoảng thời gian mua sắm vui vẻ và thú vị tại đây! <br>Số đơn hàng của quý khách là $order_id. Vui lòng theo dõi thông tin chi tiết bên dưới:";
		$html.= "<br>Gian hàng sẽ liên hệ với khách hàng để xác nhận chi tiết giao dịch. Khi đơn đặt hàng được xác nhận, gian hàng sẽ bắt đầu chuyển hàng cho quý khách hàng. <br><br>";
	    $html.="<table width=\"100%\" border=\"1\" cellspacing=\"1\">
			      <tr>
			        <th width=\"18\">TT</th>
			        <th width=\"513\">Tên sản phẩm</th>
			        <th width=\"142\">Giá (VNĐ)</th>
			        <th width=\"111\">Số lượng</th>
			        <th width=\"165\">Tổng (VNĐ)</th>
			      </tr>";
			      $i=1; foreach ($order_detail as $item) {
			      $html.="<tr>
			        <td>$i</td>
			        <td>$item->name_</td>";
			      $html.="<td>".$this->getNicePrice($item->price_)."</td>";
			      $html.="<td>".$item->quantity_."</td>";
			      $html.="<td>".$this->getNicePrice(intval($item->price_*$item->quantity_))."</td>";
			      $html.="</tr>";
			      $i++;
	      }
	    $html.="</table><br>";
	    
	    $html.="<p><strong>Thành tiền: ".$this->getNicePrice(intval($order->total_amount_))." VNĐ</strong></p>";
		$email = $order->email_;
		$from = "webmaster@muarenhat.net";
		$from_name = "MuaReNhat.NET";
		$subject = "[muarenhat.net] Đơn đặt hàng - ".$order->name_." ".date("d-m-Y",strtotime($order->order_date_));
	    smtpmailer($email, $from, $from_name, $subject, $html);
	    $email = "truongnguyensmart@gmail.com";
	    smtpmailer($email, $from, $from_name, $subject, $html);
		//session_start();
		unset($_SESSION['cart']);
		$this->loadHeader();
		$this->load->view("completed.html");
		$this->load->view("footer.html");
	}
	
	public function Order() {
		$a = session_id();
		if(empty($a)) session_start();
		// update user profile
		$user_id = isset($_POST['userid'])?$_POST['userid']:'';
		$name = isset($_POST['fullname'])?$_POST['fullname']:'';
		$phone = isset($_POST['phone'])?$_POST['phone']:'';
		$email = isset($_POST['email'])?$_POST['email']:'';
		$address = isset($_POST['address'])?$_POST['address']:'';
		$tinh = isset($_POST['tinh'])?$_POST['tinh']:'';
		$sql = "UPDATE mb_user SET name_='$name',phone_='$phone',email_='$email',address_='$address',province_='$tinh' WHERE id_=".$user_id;
		$this->db->query($sql);		
		$this->load->model("mbordermodel");
		$this->load->model("mbordermanager");
		$orderModel = new MbOrderModel();
		$orderManager = new MbOrderManager();
		$status = "new";
		$orderDate = date("Y-m-d",mktime());
		$orderModel->setStatus($status);
		$orderModel->setOrderDate($orderDate);
		$total = isset($_POST['total'])?$_POST['total']:0;
		$user_id = isset($_POST['user_id'])?$_POST['user_id']:'';
		$payment_method = isset($_POST['payment'])?$_POST['payment']:'';
		$shipping_name = isset($_POST['shipfullname'])?$_POST['shipfullname']:'';
		$shipping_phone = isset($_POST['shipphone'])?$_POST['shipphone']:'';
		$shipping_address = isset($_POST['shipaddress'])?$_POST['shipaddress']:'';
		$orderModel->setShippingName($shipping_name);
		$orderModel->setShippingAddress($shipping_address);
		$orderModel->setShippingPhone($shipping_phone);
		$orderModel->setUserId($user_id);
		$orderModel->setTotal($total);
		$orderModel->setPayMentMethod($payment_method);
		$order_id = $orderManager->insert($orderModel);
		$_SESSION['orderid']= $order_id;
		// insert into order product
		$this->load->model("mborderproductmodel");
		$this->load->model("mborderproductmanager");
		$cart_data = $this->getCart();
		$basket = $cart_data['basket'];
		foreach ($basket as $pid => $item) {
			$orderProductModel = new MbOrderProductModel();
			$orderProductManager = new MbOrderProductManager();
			$orderProductModel->setOrderId($order_id);
			$orderProductModel->setProductId($pid);
			$quantity = $item['quantity'];
			$price = $item['price'];
			$orderProductModel->setQuantity($quantity);
			$orderProductModel->setPrice($price);
			// $orderProductModel->setStoreId($storeId);
			$orderProductManager->insert($orderProductModel);
		}
		redirect(site_url('checkout/completed'));
	}
	
	public function getCart() {
		$a = session_id();
		if(empty($a)) session_start();
		$data['cart'] = isset($_SESSION['cart'])?$_SESSION['cart']:array('pid'=>array());
		$this->load->model("mbproductmodel");
		$this->load->model("mbproductmanager");
		$productManager = new MbProductManager();
		$basket = array();
		$total = 0;
		if (is_array($data['cart']['pid'])) {
		foreach ($data['cart']['pid'] as $pid) {
			$productModel = new MbProductModel();
			// echo $item;
			$productModel->setId($pid);
			$product = $productManager->select($productModel);
		    if (isset($product) & count($product)>0) {
				// print_r($product[0]);
				$basket[$pid]['product'] =  $product[0];
				$basket[$pid]['quantity'] =  $data['cart']['quantity'][$pid];
				//$price_temp = intval($product[0]->getPrice()*$basket[$pid]['quantity']);
				$basket[$pid]['price'] = intval($product[0]->getPrice()*$basket[$pid]['quantity']);
				$total+=$basket[$pid]['price'];				
		    }
		}
		}
		$data['basket'] = $basket;
		$data['total'] = $total;
		return $data;
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
	
	public function getNicePrice($price)
	{
		if (intval($price)==0) {
			return 0;
		}
		$price = strrev($price);
		$arr = str_split($price,3);
		$result = implode(".", $arr);
		$result= strrev($result);
	    return $result;
	}
	
}


