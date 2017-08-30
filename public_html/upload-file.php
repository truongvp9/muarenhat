<?php
include("visqua.compress.php");
$uploaddir = './uploads/'; 
$file = $uploaddir . basename($_FILES['uploadfile']['name']); 
if($_FILES['uploadfile']['type'] == "image/jpeg" || $_FILES['uploadfile']['type'] == "image/png" || $_FILES['uploadfile']['type'] == "image/gif") { 
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
	  $size = getimagesize($file);
	  $width = $size[0];
	  $resize="";
	  if ($width>700) {
	      $resize="700x700";
	  }
	  else {
		  $resize="";
	  }
	  $api_array = array
	  (
			'url_api' => "http://api.vn.visqua.com",
			'token' => "29365194",
			'resize' => $resize,
			'uploadfile' => $file,
			'keep_orig_file' => "yes",
			'username' => "truongsmart",
			"w_type" => "image",
			"w_gravity_t" => '',
			"w_gravity_i" => "southeast",
			"w_fill" => '',
			"w_pointsize" => '',
			'w_draw_t' => '',
			'w_draw_i' => "image over 20,60 0,0 'logo_muarenhat.png'"
	);
  /*
  	visqua_compress($api_array); //call visqua api
  */
  echo "success"; 
} else {
	echo "error";
}
}
else {
	echo "error";
}
?>
