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


if(isset($_REQUEST["loc"])){
	$loc      = isset($_GET['loc']) ? $_GET['loc'] : '0,0';
	$date           = isset($_GET['t']) ? $_GET['t'] : '2016-10-10 00:00:00';
	if($loc != "Unavailable"){
		$file = 'route.log';
		$logdata = "$loc,$date\n";
		file_put_contents($file, $logdata, FILE_APPEND | LOCK_EX);
	}
	$addresses = json_decode(file_get_contents('family.json'));

	foreach($addresses->features as $feature) {
		$lon =$feature->geometry->coordinates[0];
		$lat =$feature->geometry->coordinates[1];

		$distance = distance($latitude , $longitude, $lat, $lon, "K");
		if(abs($distance) <1) {
			$msg = "[".$lon.",".$lat."] is within ".$distance." KM of point[".$latitude.",".$longitude."]<br>";
			$url = "http://smartbus-demo.ap-southeast-1.elasticbeanstalk.com/pushwoosh/send.php?msg=".$msg ;
			//open connection
			$ch = curl_init();
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL,$url);

			//execute post
			$result = curl_exec($ch);
		}
	}

}
?>
