<?php
require("db.php");

$conn = mysql_connect($mysql_server, $mysql_username , $mysql_password)  or
    die("Could not connect: " . mysql_error());

mysql_select_db($mysql_dbname);
  $latitude       = isset($_GET['latitude']) ? $_GET['latitude'] : '0';
    $latitude       = (float)str_replace(",", ".", $latitude); // to handle European locale decimals
    $longitude      = isset($_GET['longitude']) ? $_GET['longitude'] : '0';
    $longitude      = (float)str_replace(",", ".", $longitude);    
    $speed          = isset($_GET['speed']) ? $_GET['speed'] : '0';
    $direction      = isset($_GET['direction']) ? $_GET['direction'] : '0';
    $distance       = isset($_GET['distance']) ? $_GET['distance'] : '0';
    $distance       = (float)str_replace(",", ".", $distance);
    $date           = isset($_GET['date']) ? $_GET['date'] : '0000-00-00 00:00:00';
    $date           = urldecode($date);
    $locationmethod = isset($_GET['locationmethod']) ? $_GET['locationmethod'] : '0';
    
    $username       = isset($_GET['username']) ? $_GET['username'] : 0;
    $phonenumber    = isset($_GET['phonenumber']) ? $_GET['phonenumber'] : '0';
    $sessionid      = isset($_GET['sessionid']) ? $_GET['sessionid'] : 0;
    $accuracy       = isset($_GET['accuracy']) ? $_GET['accuracy'] : 0;
    $extrainfo      = isset($_GET['extrainfo']) ? $_GET['extrainfo'] : '0';
    $eventtype      = isset($_GET['eventtype']) ? $_GET['eventtype'] : '0';

$sql = "INSERT INTO gpslocations(lastUpdate,latitude,longitude,phoneNumber,userName,sessionID,speed,direction,distance,gpsTime,locationMethod,accuracy,extraInfo,eventType)
VALUES(CURRENT_TIMESTAMP, $latitude ,  $longitude , $phonenumber,$username ,$sessionid ,$speed ,$direction,$distance, '$date' ,$locationmethod ,$accuracy,$extrainfo,$eventtype );";

$file = 'LAST.html';
file_put_contents($file, $sql);
            
$retval = mysql_query( $sql, $conn );
            
            if(! $retval ) {
               die('Could not enter data: ' . mysql_error());
            }
mysql_close($conn);
echo "Entered data successfully\n";

?>