<?php // echo "hi"; 
	$name 	= isset($_POST['fullname'])?$_POST['fullname']:'';
	$email 	= isset($_POST['email'])?$_POST['email']:'';
	$title = isset($_POST['title'])?$_POST['title']:'';
	$content 	= isset($_POST['feedback'])?$_POST['feedback']:'';
	$review_rate = isset($_POST['review_rate'])?$_POST['review_rate']:'';
	require("mailer.php");
	$to = "truongk17cntt@gmail.com";
	$from = $email;
	$from_name = $name;
	//$subject = "Lien he voi gian hang";
	$body = "Ho va ten: ".$name;
	/*$body .= "<br>Dia chi: ".$address;
	$body .= "<br>Dien thoai: ".$phone;
	$body .= "<br>Di dong: ".$mobile;
	$body .= "<br>Fax: ".$fax;*/	
	$body .= "<br>Email: ".$email;
	$body .= "<br>View rate: ".$review_rate;
	$body .= "<br>Noi dung: ".$content;
	$ok = smtpmailer($to, $from, $from_name, $title, $body);	
	if ($ok) {
		echo "Cam on ban da danh gia!";
	}
	//header("Location: http://muarenhat.net/");
?>

Click <a href="http://muarenhat.net">vao day</a> de tro lai trang chu!