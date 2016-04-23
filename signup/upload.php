<?php
$target_dir = $_POST['username'] . '/';
$target_file = $target_dir . basename($_FILES['upload']['name']);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$reply['status']= "";
// Check if image file is a actual image or fake image
ini_set('display_errors', 1);

$path = "/student/UTORID/www/309assignment2/upload_files/";

$path2 = "/student/UTORID/www/309assignment2/";

if (isset($_POST['userid'])){
	$p=$_POST['userid'];
}

        // Check for an uploaded file:
        if (isset($_FILES['upload'])) {
                // Validate the type. Should be JPEG or PNG.
                $allowed = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
                if (in_array($_FILES['upload']['type'], $allowed)) {
                        // Move the file over.
                        if (move_uploaded_file 
				($_FILES['upload']['tmp_name'], $path
								. $p
								)) 
			{
				chmod($path . $p, 0777);
				$reply['status'] = 'ok';
                                print_r('<p><em>The file has been uploaded!</em></p>');
                        } 

                } else { 
                        print_r('<p class="error">Please upload a JPEG or PNG image.</p>');
                }
        }
	
	if (isset($_POST['url']) && isset($_POST['user'])) {
		copy($path2 . $_POST['url'], $path . $_POST['user']);
		chmod($path . $_POST['user'], 0777);
	$reply['status'] = 'ok';
	}
print json_encode($reply);
?>
