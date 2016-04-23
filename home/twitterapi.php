<?php
/**
 * Created by IntelliJ IDEA.
 * User: nmukena
 * Date: 2/14/16
 * Time: 6:14 PM
 */
if(($_REQUEST['query'])=='') {
    $reply['status'] = 'error: guess parameter not supplied';
    goto leave;
}
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "4910159825-tEjC42BgsU1W7iZ20pETnKRIhipFZzfYMqwzp4L",
    'oauth_access_token_secret' => "P4hct9FdkNq7iBMb2MQa4MNzyjE95N0IJyRjJGMw5yiDj",
    'consumer_key' => "fcHH7pLzvntmaTlbRWmPXH2fi",
    'consumer_secret' => "1O0GfERCGuiGEiEosPBWDWdOiNr1bzPidwHGOwZGdx16qsgryF"
);

$url = "https://api.twitter.com/1.1/search/tweets.json";
$requestMethod = "GET";
$getField = '?q='.urlencode($_REQUEST['query']).'&count=100&result_type=mixed';
$twitter = new TwitterAPIExchange($settings);

$string = json_decode($twitter->setGetfield($getField)
    ->buildOauth($url, $requestMethod)
    ->performRequest(), $assoc=TRUE );


$text = '';
foreach($string['statuses'] as $items)
{
    $text.=substr($items['text'], 0, strlen($items['text'])-27);
}

$words = array_count_values(str_word_count($text, 1));

function max_key($array)
{
    $max = max($array);
    $my_key="";
    foreach ($array as $key => $val)
    {
        if ($val == $max){
            $my_key=$key;
        }
    }
    return $my_key;
}

$reply['array'] = array();

$boring = array('https');
foreach (range(0, 100) as $number) {
    $max = max_key($words);
    if ((strlen($max) >= 4) and !in_array($max, $boring) and (strpos($max, "'") == false)){
        array_push($reply['array'], $max);
    }
    unset($words[$max]);
}

$reply['array']=array_slice($reply['array'],0,round(sizeof($reply['array'])));
$reply['status']='';

leave:
print json_encode($reply);

?>
