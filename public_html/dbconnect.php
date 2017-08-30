<?php
$db_user = 'nguyen54_muare';
$db_pass = 'muare789';
$db_name = 'nguyen54_muare';
$link = mysql_connect('localhost', $db_user, $db_pass);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

// the current db
$db_selected = mysql_select_db($db_name, $link);
if (!$db_selected) {
    die (mysql_error());
}


?>
