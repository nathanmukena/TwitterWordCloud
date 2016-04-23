<?php
$array = array();

// Check for an image name in the URL:
if (isset($_GET['image'])) {
	$array[0] = 'predefined_pictures/1.jpg';
	$array[1] = "predefined_pictures/2.jpg";
	$array[2] = "predefined_pictures/3.jpg";
	
print json_encode($array);
}
?>
