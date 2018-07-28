<?php

# Build GeoJSON feature collection array
$geojson = array(
   'type'      => 'FeatureCollection',
   'features'  => array()
);

if (($handle = fopen("address.csv", "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		  $feature = array(
        'type' => 'Feature',
        'geometry' => array(
            'type' => 'Point',
            'coordinates' => array(
                $data[5],
                $data[4]
            )
        ),
        'properties' => array('id' => $data[0],'name' => $data[1],'pin'=>$data[2],'address'=>$data[3],'type'=>'home')
    );
    array_push($geojson['features'], $feature);
		}
}
var_dump($geodata );
$file = 'address.json';
$geodata = json_encode($geojson, JSON_NUMERIC_CHECK);
file_put_contents($file, $geodata);

header('Content-type: application/json');
echo $geodata 
?>