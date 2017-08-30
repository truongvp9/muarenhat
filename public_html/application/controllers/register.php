<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
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

	 
	public function index()
	{
		// include_once ("recaptchalib.php");
		$data['host'] = $this->config->site_url();
		$this->loadHeader();	
		if (isset($_POST['signup'])) $data['error']=$this->submit();
	    
		$data['fullname'] = isset($_POST['fullname'])?$_POST['fullname']:'';
                        
        $data['email'] = isset($_POST['email'])?$_POST['email']:'';
            
        $data['login'] = isset($_POST['username'])?$_POST['username']:'';
            
        $data['password'] = isset($_POST['password'])?$_POST['password']:'';

        $data['password_confirm'] = isset($_POST['password_confirm'])?$_POST['password_confirm']:'';
		
        $this->load->view("register.html",$data);
		$this->load->view("footer.html");			
	}

	/* load header */
	
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
		$this->load->view('header.html',$data);		
	}	
	/**
	 * 
	 *  register a new user
	 * 
	 */
	
	public function submit() {
		    
		    $name = $_POST['fullname'];
            
            //$address = $_POST['address'];
            
            $email = $_POST['email'];
            
            //$phone = $_POST['tel'];   

            $account = $_POST['username'];
            
            $password = sha1($_POST['password']);
		
			$this->load->model('mbusermanager');
			$this->load->model('mbusermodel');
			$mbUserModelManager = new MbUserManager();
			$mbUserModel = new MbUserModel();			
			$mbUserModel->setAccount($account);
			$mbUserModel->setPassword($password);
			$mbUserModel->setName($name);
			$mbUserModel->setEmail($email);
			$mbUserModel->setActive(1);
			//$mbUserModel->setPhone($phone);
			//onyprint_r($mbUserModel);die;
			# was there a reCAPTCHA response?
			/*if (isset($_POST["recaptcha_response_field"])) {
					//include_once ("recaptchalib.php");
					$privatekey = "6LeoT8kSAAAAAEu70o1sIsjDa4k911hz9gXmXiyM";
			        $resp = recaptcha_check_answer ($privatekey,
			                                        $_SERVER["REMOTE_ADDR"],
			                                        $_POST["recaptcha_challenge_field"],
			                                        $_POST["recaptcha_response_field"]);
			
			        if ($resp->is_valid) {*/
			            // echo "You got it!";
			        if ($_POST['captcha']==sha1('muaban123')) { 
			            $mbUserModelManager->insert($mbUserModel);
			
						$this->load->library('email');
			
						$subject = 'Dang ky thanh cong';
			
						// $message = 'Chao ban, chuc mung ban da dang ky thanh vien tai trang web muaban12.net';
						$message = $this->getMessage($mbUserModel);
						
						$mbUserModelManager->sendEmail($email,$subject,$message);
						// login 
						$this->load->library('session'); 
						$newdata = array(
							   'account'  => $account,
							   'logged_in' => TRUE
						);
						//print_r($_SESSION['cart']); die;
						$this->session->set_userdata($newdata); 
						redirect(site_url());
			        }        
			        /*} else {
			                # set the error code so that we can display it
			                $error = $resp->error;
			                return $error;
			                //die();
			        }
			}*/
			//return;			
	} 
	
	public function checkuser() {
		$user = $_REQUEST['username'];
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$userModel = new MbUserModel();
		$userModel->setAccount($user);
		$userManager = new MbUserManager();
		$result = $userManager->select($userModel);
		$valid = 'true';		
		if (count($result)>0) {
			$valid = 'false';
		}		
		echo $valid;die;		
	}
	
	public function checkemail() {
		$email = isset($_REQUEST['email'])?$_REQUEST['email']:'';
		$this->load->model("mbusermodel");
		$this->load->model("mbusermanager");
		$userModel = new MbUserModel();
		$userModel->setEmail($email);
		$userManager = new MbUserManager();		
		$result = $userManager->select($userModel);
		$valid = 'true';
		if (count($result)>0) {
			$valid = '"Email đã được đăng ký."';
		}
		echo $valid;die;		
	}
	
	public function getMessage($mbUserModel) {
		$myweb = trim(base_url(),'/');
		$msg = '<table width="600" border="0" cellpadding="0" cellspacing="0">
				  <tbody>
				    <tr>
				      <td colspan="3" bgcolor="#ffffff" width="1" height="10"><div></div></td>
				    </tr>
				    <tr>
				      <td bgcolor="#FFFFFF" width="10" height="40"><div></div></td>
				      <td valign="bottom" width="580" align="left" bgcolor="#ffffff"><a href="'.$myweb.'" title="$myweb" target="_blank"><strong>'.$myweb.'</strong></a></td>
				      <td bgcolor="#ffffff" width="10" height="40"><div></div></td>
				    </tr>
				    <tr>
				      <td colspan="3" bgcolor="#ffffff"><hr /></td>
				    </tr>
				    <tr>
				      <td bgcolor="#ffffff"></td>
				      <td align="left" bgcolor="#ffffff"><table width="100%" border="0" cellpadding="0" cellspacing="8">
				        <tbody>
				          <tr>
				            <td valign="top" align="center"><strong>&#272;&#259;ng k&yacute; t&agrave;i kho&#7843;n tr&ecirc;n '.$myweb.' </strong></td>
				          </tr>
				          <tr>
				            <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
				              <tbody>
				                <tr>';
                  		$msg.='<td>Ch&agrave;o&nbsp;<strong>'.$mbUserModel->getName().'</strong>&nbsp;[<a href="$myweb" target="_blank">'.$mbUserModel->getEmail().'</a>]<br />';
                  		$msg.='C&#7843;m &#417;n b&#7841;n &#273;&atilde; &#273;&#259;ng k&yacute; t&agrave;i kho&#7843;n t&#7841;i&nbsp;<a href="'.$myweb.'" target="_blank">'.$myweb.'</a><br />
				                    <br />
                  					- V&#7873; t&agrave;i kho&#7843;n c&#7911;a b&#7841;n:&nbsp;<a href="'.site_url('myaccount').'" target="_blank">click v&agrave;o &#273;&acirc;y</a><br />
				                    - V&#7873;&nbsp;<a href="'.$myweb.'" target="_blank">muaban12.net</a><br />
				                    <br />
				                    M&#7885;i th&#7855;c m&#7855;c xin li&ecirc;n h&#7879;:<br />
				                    <a href="'.$myweb.'" target="_blank">'.$myweb.'</a><br />
				                    Tel:   0125.294.3166  <br />
				                    Email:&nbsp;<a href="mailto:lienhe@muaban12.net" target="_blank">lienhe@muaban12.net</a><br /></td>
				                </tr>
				              </tbody>
				            </table></td>
				          </tr>
				        </tbody>
				      </table></td>
				      <td bgcolor="#ffffff"></td>
				    </tr>
				    <tr>
				      <td colspan="3" bgcolor="#ffffff"></td>
				    </tr>
				  </tbody>
				</table>';
		return $msg;
	}
	
}

