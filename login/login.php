<?php
/**
 * Created by IntelliJ IDEA.
 * User: nmukena
 * Date: 2/21/16
 * Time: 4:06 AM
 */
header('Content-Type: application/json');
session_save_path("sess");
session_start();
$errors = array();
$reply = array();
if (empty($_REQUEST['username'])) {
    $errors[] = 'You forgot to enter your username.';
}
elseif (empty($_REQUEST['password'])){
    $errors[] = 'You forgot to enter your password.';
}
else {
    $dbconn = pg_connect("host=localhost dbname=UTORID user=UTORID password=PASSWORD")
    or die('Could not connect: '.pg_last_error());
    $stat = pg_connection_status($dbconn);
    if ($stat !== PGSQL_CONNECTION_OK) {
        $errors[] = 'Connection status bad';
    } else {
        $p = $_REQUEST['username'];
        $e = MD5($_REQUEST['password']);
        $query = "select * from login where username='$p' and password='$e';";
        $result = pg_query ($query);
        $row = pg_fetch_array($result); // Return a record, if applicable.
        if (!empty($row)) { // A record was pulled from the database
            // Set the session data & redirect.
            $_SESSION['username'] = $row[1];
            $_SESSION['password'] = $row[2];
            $reply['status']='ok';
        }else { // No record matched the query.
            $errors[] = 'The username and password entered do not match those on file.';
        }
    }
    pg_close($dbconn); // Close the database connection.
}
if (!empty($errors)) { // Print any error messages.
    $reply['status'] = '<p>Error!</p>
     <p class=”error”>The following error(s) occurred:<br />';
    foreach ($errors as $msg) { // Print each error.
        $reply['status'].= "$msg<br />\n";
    }
    $reply['status'].='</p><p>Please try again.</p>';
}
print json_encode($reply);
?>
