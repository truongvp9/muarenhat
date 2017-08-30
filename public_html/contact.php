<?php
	$name 	= isset($_POST['fullname'])?$_POST['fullname']:'';
	$address= isset($_POST['address'])?$_POST['address']:'';
	$phone 	= isset($_POST['phone'])?$_POST['phone']:'';
	$mobile = isset($_POST['mobile'])?$_POST['mobile']:'';
	$fax 	= isset($_POST['fax'])?$_POST['fax']:'<chua co>';
	$email 	= isset($_POST['email'])?$_POST['email']:'';
	$content 	= isset($_POST['feedback'])?$_POST['feedback']:'';
	require("mailer.php");
	$to = "truongk17cntt@gmail.com";
	$from = $email;
	$from_name = $name;
	$subject = "Lien he quang cao";
	$body = "Ho va ten: ".$name;
	$body .= "<br>Dia chi: ".$address;
	$body .= "<br>Dien thoai: ".$phone;
	$body .= "<br>Di dong: ".$mobile;
	$body .= "<br>Fax: ".$fax;
	$body .= "<br>Email: ".$email;
	$body .= "<br>Noi dung: ".$content;
	$ok = smtpmailer($to, $from, $from_name, $subject, $body);	
	if ($ok) {
	    header("location:http://muarenhat.net");
		echo "This form is sent!";
	}
?>
