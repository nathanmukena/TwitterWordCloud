<?php
session_save_path("sess");
session_start();
if (!isset($_SESSION['username'])) {
	// Need the functions to create an absolute URL:
	$url = "/309assignment2/login.html";
	header("Location: $url");
} else { // Delete the cookies.
    session_destroy();
	header("Location: /~UTORID/309assignment2/index.html");
}
//include ('includes/footer.html');
?>

