<?php
$now = new DateTime();
$send = $now->format('Y-m-d H:i:s');    // MySQL datetime format
$fields = array(
            'send'=>$send,
'bid'=>1,
'rid'=>1,
'lat'=>1.339981,
'lng'=>103.75572,

        );

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
$fields_string = rtrim($fields_string,'&');
$url = "http://nas/smartbus/geo/putloc.php";
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

//execute post
$result = curl_exec($ch);
print $result;
?>