<?php
header('Content-Type: application/json');
session_save_path("sess");
session_start();
$reply = array();
if (!isset($_SESSION['username'])) {
	$reply['status']='error';
}else{
    $reply['status']='ok';
    $reply['username']= $_SESSION['username'];
}
print json_encode($reply);

