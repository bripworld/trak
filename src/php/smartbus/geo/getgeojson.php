<?php
require("db.php");

mysql_connect($mysql_server, $mysql_username , $mysql_password) or
    die("Could not connect: " . mysql_error());
mysql_select_db($mysql_dbname);

# Build GeoJSON feature collection array
$geojson = array(
   'type'      => 'FeatureCollection',
   'features'  => array()
);

$result = mysql_query("SELECT  id, familyid, name, postalcode, address, lng ,lat FROM markers");

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
    $feature = array(
        'type' => 'Feature',
        'geometry' => array(
            'type' => 'Point',
            'coordinates' => array(
                $row[5],
                $row[6]
            )
        ),
        'properties' => array('name' => 'lastfound')
    );
    # Add feature arrays to feature collection array
    array_push($geojson['features'], $feature);
}

mysql_free_result($result);

$file = 'geodata.json';
$geodata = json_encode($geojson, JSON_NUMERIC_CHECK);
file_put_contents($file, $geodata);

header('Content-type: application/json');
echo $geodata 
?>