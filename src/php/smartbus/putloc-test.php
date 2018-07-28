<?php
$now = new DateTime();
$send = urlencode($now->format('Y-m-d H:i:s'));    // MySQL datetime format
$fields = array(
'lat'=>1.274929,
'lon'=>103.843549,
        );

$fields_string= "";
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string.= $key.'='.$value.'&'; }

$url = "http://game/smartbus/track.php?lat=1.274929&lon=103.843549&t=";
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

//execute post
$result = curl_exec($ch);

?>