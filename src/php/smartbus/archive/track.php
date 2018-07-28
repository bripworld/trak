
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=drawing"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	if ($unit == "K") {
		return ($miles * 1.609344);
	} else if ($unit == "N") {
		return ($miles * 0.8684);
	} else {
		return $miles;
	}
}


if(isset($_REQUEST["lat"])){

	$latitude       = isset($_GET['lat']) ? $_GET['lat'] : '0';
	$latitude       = (float)str_replace(",", ".", $latitude); // to handle European locale decimals
	$longitude      = isset($_GET['lon']) ? $_GET['lon'] : '0';
	$longitude      = (float)str_replace(",", ".", $longitude);
	$date           = isset($_GET['t']) ? $_GET['t'] : '0000-00-00 00:00:00';

	$file = 'log.csv';
	$logdata = "$longitude,$latitude,$date\n";
	file_put_contents($file, $logdata, FILE_APPEND | LOCK_EX);


	$addresses = json_decode(file_get_contents('address.json'));

	foreach($addresses->features as $feature) {
		$lon =$feature->geometry->coordinates[0];
		$lat =$feature->geometry->coordinates[1];

		$distance = distance($latitude , $longitude, $lat, $lon, "K");
		if(abs($distance) <0.5) {
			$msg = "Point [".$lat.",".$lon."] is within ".$distance." KM of point[".$latitude.",".$longitude."]<br>";
			$url = "http://smartbus-demo.ap-southeast-1.elasticbeanstalk.com/pushwoosh/send.php?msg=".$msg ;
			//open connection
			$ch = curl_init();
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL,$url);

			//execute post
			$result = curl_exec($ch);
		}
	}

}else{
	$fp = fopen("trackdata.json","r") or die("can't open the file");
	$request = fread($fp,filesize("trackdata.json"));
	print_r($request);
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>SmartBus GEO Tracking</title>
	</head>
	<body>
		<div></div>
	</body>
</html>