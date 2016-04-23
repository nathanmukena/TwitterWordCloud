<?php
/**
 * Created by IntelliJ IDEA.
 * User: nmukena
 * Date: 2/21/16
 * Time: 6:13 PM
 */
header('Content-Type: application/json');
session_save_path("login/sess");
session_start();
$reply = array();
$reply['status']='';
if ($_POST['cloudHtml'] && $_SESSION['username']) {
    $dbconn = pg_connect("host=localhost dbname=UTORID user=UTORID password=PASSWORD")
    or die('Could not connect: ' . pg_last_error());
    $stat = pg_connection_status($dbconn);
    if ($stat !== PGSQL_CONNECTION_OK) {
        $reply['status'] .= 'Connection status bad';
    }else{
        // Add the cloud html.
        $reply['status'] .= 'Connection status good';
        date_default_timezone_set("America/Toronto");
        $now= time().date("Y-m-d H:i");
        $user=$_SESSION['username'];
        $ht=($_POST['cloudHtml']);
        $query = "INSERT INTO clouds(time, username, html, likes) VALUES('" . $now . "', '" . $user . "', '" . "$ht" . "', 0)";
        $result = pg_query($query); // Run the query.
        if ($result) { // If it ran OK.
            $reply['status'] = 'ok';
        } else { // If it did not run OK.
            // Send a message to the error log, if desired.
            $reply['status'].=pg_last_error();
            $reply['status'] .= '<p>Your cloud could not be added to the timeline. Please
                                        try again</p>';
        }
    }
}else{
    $reply['status'] .= '<p>Your cloud could not be added to the timeline. Please
                                        try again</p>';
}
print json_encode($reply);
?>
