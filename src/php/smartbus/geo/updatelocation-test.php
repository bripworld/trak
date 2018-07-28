<?php
$now = new DateTime();
$send = $now->format('Y-m-d H:i:s');    // MySQL datetime format
$fields = array(
'latitude'  => 1.274929,
'longitude' => 103.843549,
'speed'     => '2',
'direction' => '0',
'distance'  => '0',
'distance'  => '2.225',
'date'      => '2016-10-03 018:50:00',
'locationmethod' => '',
'username'  => '0',
'phonenumber' => '',
'sessionid' => '0',
'accuracy'  =>'0',
'extrainfo' => '',
'eventtype'=> '',
        );



//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
$fields_string = rtrim($fields_string,'&');
$url = "http://nas/smartbus/geo/updatelocation.php";


//$url = "http://smartbusdemo-env.ap-southeast-1.elasticbeanstalk.com/geo/updatelocation.php";

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