<?php 
// This is the registration page for the site.
// Include the configuration file for error management and such.

//require_once ('includes/config.inc'); *****************************************

// Set the page title and include the HTML header.
$page_title = 'Register';
$reply = array();
$reply['status']= "";
//include ('includes/header.html'); ****************************************
//$_REQUEST=array('first_name'=>'Nathan', 'last_name'=>'Mukena', 'email'=>'nmukena@live.fr',
  // 'username'=>'libert2', 'password1'=>'coco', 'password2'=>'coco');

if (isset($_REQUEST)) { // Handle the form.
    //require_once ('../mysql_connect.php'); // Connect to the database.
    // Check for a first name.
    if (preg_match("/^[[:alpha:].' -]{2,15}$/", $_REQUEST['first_name'])) {
        $fn = $_REQUEST['first_name'];
    } else {
        $fn = FALSE;
        $reply['status'] .= '<p>Please enter your first name!</p>';
    }
    // Check for a last name.
    if (preg_match("/^[[:alpha:].' -]{2,30}$/", $_REQUEST['last_name'])) {
        $ln = $_REQUEST['last_name'];
    } else {
        $ln = FALSE;
        $reply['status'] .= '<p>Please enter your last name!</p>';
    }
    // Check for an email address.
    if (preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+.[a-z]{2,4}$/", $_REQUEST['email'])) {
        $e = $_REQUEST['email'];
    } else {
        $e = FALSE;
        $reply['status'] .= '<p>Please enter a valid email address!</p>';
    }


    $dbconn = pg_connect("host=localhost dbname=UTORID user=UTORID password=PASSWORD")
    or die('Could not connect: ' . pg_last_error());


    // Check for a username.
    $stat = pg_connection_status($dbconn);
    if ($stat !== PGSQL_CONNECTION_OK) {
        $reply['status'] .= 'Connection status bad';
    } else {
        if (preg_match("/^[[:alnum:]_]{4,20}$/", $_REQUEST['username'])) {
            $u = $_REQUEST['username'];
        } else {
            $u = FALSE;
            $reply['status'] .= '<p>Please enter a valid username!</p>';
        }
        // Check for a password and match against the confirmed password.
        if ($_REQUEST['password1'] == $_REQUEST['password2']) {
            $p = MD5($_REQUEST['password1']);
        } else {
            $p = FALSE;
            $reply['status'] .= '<p>Your password did not match the confirmed password!</p>';
        }
        if ($fn && $ln && $e && $u && $p) { // If everything's OK.
            $result = pg_query($dbconn, "SELECT * FROM login");
            $rows = pg_num_rows($result);
            $query = "select * from login where username='$u'";
            $result = pg_query($query);
            if (pg_num_rows($result) == 0) { // Available.
                // Add the user.
                $query = "insert into login(id, username, password, email, password_hint) VALUES($rows+1,'$u','$p','$e','$fn')";
                $result = pg_query($query); // Run the query.
                if ($result) { // If it ran OK.
                    $reply['status'] = 'ok';
                } else { // If it did not run OK.
                    // Send a message to the error log, if desired.
                    $reply['status'] .= '<p>You could not be registered due to a system error. We apologize for any inconvenience.</p>';
                }
            } else { // The username is not available.
                $reply['status'] .= '<p>That username is already taken.</p>';
                $reply['status'] .= $result;
            }
            pg_close(); // Close the database connection.
        } else { // If one of the data tests failed.
            $reply['status'] .= '<p>Please try again.</p>';
        }

    }
}
print json_encode($reply);
// End of the main Submit conditional.
?>
