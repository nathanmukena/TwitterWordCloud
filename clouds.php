<?php
/**
 * Created by IntelliJ IDEA.
 * User: nmukena
 * Date: 2/21/16
 * Time: 5:24 PM
 */
$reply = array();
$reply['status']= "";
if (isset($_REQUEST)) {
    $dbconn = pg_connect("host=localhost dbname=UTORID user=UTORID password=PASSWORD")
    or die('Could not connect: ' . pg_last_error());
    $stat = pg_connection_status($dbconn);
    if ($stat !== PGSQL_CONNECTION_OK) {
        $reply['status'] .= 'Connection status bad';
    }else{
        $query = "select * from clouds";
        $result = pg_query ($query);
        $rows = pg_fetch_array($result);
        while($rows){
            $reply['clouds'][]=$rows;
            $rows = pg_fetch_array($result);
        }
        $reply['status']='ok';
    }
}
print json_encode($reply);
?>
