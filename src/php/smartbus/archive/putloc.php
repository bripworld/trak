<?php
require("db.php");


$conn = mysql_connect($mysql_server, $mysql_username , $mysql_password)  or
    die("Could not connect: " . mysql_error());

mysql_select_db($mysql_dbname);

if (isset($_GET['send'])) {
  $send = $_GET['send'];
}
else {
  $send = $_POST['send'];
}

if (isset($_GET['bid'])) {
  $bid = $_GET['bid'];
}
else {
  $bid = $_POST['bid'];
}
if (isset($_GET['rid'])) {
  $rid = $_GET['rid'];
}
else {
  $rid = $_POST['rid'];
}
if (isset($_GET['lat'])) {
  $lat = $_GET['lat'];
}
else {
  $lat = $_POST['lat'];
}
if (isset($_GET['lng'])) {
  $lng = $_GET['lng'];
}
else {
  $lng = $_POST['lng'];
}

$sql = "INSERT INTO pos(send,bid,rid,received,lat,lng) ". "VALUES('$send',$bid,$rid, NOW(),$lat,$lng)";
$file = 'last.sql';
file_put_contents($file, $sql);
$retval = mysql_query( $sql, $conn );
            
            if(! $retval ) {
               die('Could not enter data: ' . mysql_error());
            }
mysql_close($conn);
echo "Entered data successfully\n";
?>