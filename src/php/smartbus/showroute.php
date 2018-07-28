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


$currentroute = array(
'type'      => 'FeatureCollection',
'type' => 'Feature',
'geometry' => array(
'type' => 'LineString',
'coordinates' =>  array(),
'properties' => null)
);

if (($handle = fopen("route.log", "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		if($data[0]!="0" || $data[1]!="0"){
			$coords = array($data[0] ,$data[1]);
			# Add feature arrays to feature collection array
			array_push($currentroute ['geometry']['coordinates'], $coords);
		}}
	}
	fclose($handle);

	/// final add a bus icon
	# Build GeoJSON feature collection array
	$busloc = array(
	'type'      => 'FeatureCollection',
	'features'  => array()
	);
	$feature = array(
	'type' => 'Feature',
	'geometry' => array(
	'type' => 'Point',
	'coordinates' => array(
	$coords[0],
	$coords[1]
	)
	),
	'properties' => array('name' => 'lastfound')
	);
	# Add feature arrays to feature collection array
	array_push($busloc['features'], $feature);

	?>
	<!DOCTYPE html>
	<html>
		<head>
			<title>Data Layer: Styling</title>
			<link rel="manifest" href="/manifest.json">
			<meta name="viewport" content="initial-scale=1.0">
			<meta charset="utf-8">
			<style>
				html, body {
					height: 100%;
					margin: 0;
					padding: 0;
				}
				#map {
					height: 80%;
				}
			</style><script src="/js/jquery-3.1.1.min.js"></script>
				<!--[if !IE]><!-->
				<script src="/pushwoosh-web-pushes-http-sdk.js?pw_application_code=BA5E4-D6CE1"></script>
				<!--<![endif]-->
			</head>
			<body><script>pushwoosh.subscribeAtStart();</script>
				<h4>Bus Route</h4>

				<br/>
				see all files using <a href="browser.php">browse</a> utility:
				<br/>
				Delete all routes using <a href="delete.php">delete</a> utility:
				<br/>
			</div>
			<div id="map"></div>
			<script>
				function loadGeoJson(url, options) {
					var promise = new Promise(function (resolve, reject) {
						try {
							map.data.loadGeoJson(url, options, function (features) {
								resolve(features);
							});
						} catch (e) {
							reject(e);
						}
					});

					return promise;
				}

				var map;
				function initMap() {
					map = new google.maps.Map(document.getElementById('map'), {
						zoom: 14,

						center: {lat: 1.33186, lng: 103.88697}
					});

					var routeLayer = new google.maps.Data();
					var routedata = <?php echo json_encode($currentroute, JSON_NUMERIC_CHECK); ?>;
					routeLayer.addGeoJson(routedata);
					routeLayer.setMap(map)


					var busLayer = new google.maps.Data();
					var busloc = <?php echo json_encode($busloc , JSON_NUMERIC_CHECK); ?>;
					busLayer.addGeoJson(busloc);
					busLayer.setStyle({icon: 'geo/img/bus-small.png'});
					busLayer.setMap(map)


					var addressLayer = new google.maps.Data();
					addressLayer.addGeoJson('currentpos.json');
					addressLayer.setStyle({icon: 'geo/img/marker-house.png'});
					addressLayer.setMap(map);
		}

			</script>
			<script async defer
				src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh2_PcheSwNgMt-Ac4jqpkQwD8TcBfbYo&callback=initMap">
			</script>
		</body>
	</html>