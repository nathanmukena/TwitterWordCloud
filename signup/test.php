<?php

$reply = array();

$val = $_POST["url"];

$reply["status"] = $val;

print json_encode($reply);
?>
