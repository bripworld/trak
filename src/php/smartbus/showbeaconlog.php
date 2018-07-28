<html><body>
	<style type="text/css">
		html, body {height: 100%;width: 100%;}
		tr, td{border: 1px solid #ccc;}
		.ron {background-color: #0000ff;color: #ffffff;}
		.hermione {background-color: #00ff00;color: #000000;}
		.harry {background-color: #ffa500;color: #ffffff;  }
		#map {height: 80%;}
	</style>
	<script src="/js/jquery-3.1.1.min.js"></script>
	<!--[if !IE]><!-->
	<script src="/pushwoosh-web-pushes-http-sdk.js?pw_application_code=BA5E4-D6CE1"></script>
	<!--<![endif]-->
</head>
<script>pushwoosh.subscribeAtStart();</script>

<div id="map"></div><br/>
<?php
$lastloc = "";
$lastmaj_string = "";
$lastmin_string = "";

$harryroute = array(
'type'      => 'FeatureCollection',
'type' => 'Feature',
'geometry' => array(
'type' => 'LineString',
'coordinates' =>  array(),
'properties' => null)
);


$hermioneroute = array(
'type'      => 'FeatureCollection',
'type' => 'Feature',
'geometry' => array(
'type' => 'LineString',
'coordinates' =>  array(),
'properties' => null)
);

$ronroute = array(
'type'      => 'FeatureCollection',
'type' => 'Feature',
'geometry' => array(
'type' => 'LineString',
'coordinates' =>  array(),
'properties' => null)
);


echo "<table><tr><td>Date</td><td>sender</td><td>Beacon Address</td><td>loc</td><td>prox</td><td>uuid</td></tr>";

$f = fopen("beacon.log", "r");
while (($line = fgetcsv($f, 1000, "|")) !== false) {

	$sender       = $line[0];
	$t           = $line[1];
	$person= $line[2];
	$color= $line[3];
	$loc       = $line[4];
	$address      = $line[5];
	$uuid          = $line[6];
	$maj_string      = $line[7];
	$min_string       = $line[8];
	$rssi       = $line[9];
	$prox    = $line[10];
	$pow      = $line[11];
	$maj = (float)$maj_string;
	$min = (float)$min_string;

	if($loc != $lastloc && $maj_string!= $lastmaj_string  && $min_string!= $lastmin_string){
		echo "<tr class='$person'><td>".htmlspecialchars($t)."</td><td>".$sender."</td><td>".$person."</td><td>[".$loc."]</td><td>".$prox."</td><td>".$uuid."</tr>";
	}
	$data = explode(",", $loc);
	$coords = array($data[0] ,$data[1]);
	if($person =="Ron"){
		array_push($ronroute['geometry']['coordinates'], $coords);
	}else
	if($person =="Hermione"){
		array_push($hermioneroute['geometry']['coordinates'], $coords);
	}else
	if($person =="Harry"){
		array_push($harryroute['geometry']['coordinates'], $coords);
	};

	$lastloc = $loc;
	$lastmaj_string = $maj_string ;
	$lastmin_string = $min_string ;

}
fclose($f);
echo "\n</table></body></html>";
?>

<script>

	var map;
	function initMap() {
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 16,
			center: {lat: 1.2846211, lng: 103.8361181}
		});

		var ronlayer = new google.maps.Data();
		var ronroute  = <?php echo json_encode($ronroute, JSON_NUMERIC_CHECK); ?>;
		ronlayer.addGeoJson(ronroute );
		ronlayer.setStyle({fillColor: '0000ff',strokeWeight: 2});
		ronlayer.setMap(map)

		var hermionelayer = new google.maps.Data();
		var hermioneroute  = <?php echo json_encode($hermioneroute, JSON_NUMERIC_CHECK); ?>;
		hermionelayer.addGeoJson(hermioneroute );
		hermionelayer.setStyle({fillColor: '00ff00',strokeWeight: 2});
		hermionelayer.setMap(map)
		var harrylayer = new google.maps.Data();
		var harryroute  = <?php echo json_encode($harryroute, JSON_NUMERIC_CHECK); ?>;
		harrylayer.addGeoJson(harryroute );
		harrylayer.setStyle({fillColor: '#ffa500',strokeWeight: 2});
		harrylayer.setMap(map)
	}

</script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh2_PcheSwNgMt-Ac4jqpkQwD8TcBfbYo&callback=initMap">
</script>
</body>
</html>