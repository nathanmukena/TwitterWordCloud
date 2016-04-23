<?php

$reply = array();
$reply['status']= "";
if (isset($_REQUEST['log'])) {
    $log = $_REQUEST['log'];
    $dbconn = pg_connect("host=localhost dbname=UTORID user=UTORID password=PASSWORD")
    or die('Could not connect: ' . pg_last_error());
    $stat = pg_connection_status($dbconn);
    if ($stat !== PGSQL_CONNECTION_OK) {
        $reply['status'] .= 'Connection status bad';
    }else{
        $query = "UPDATE clouds SET likes = likes + 1 where log=$log";
        $result = pg_query($query);
	if (!$result){
		$reply['status'] .= pg_last_error;
        }
	else{
	//how do you know it is succesful 
        $reply['status']='ok';
	}
    }
}
print json_encode($reply);





?>
