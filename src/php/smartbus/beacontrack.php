<?php
$sender       = isset($_GET['sender']) ? $_GET['sender'] : 'NONE';
$sender       = isset($_GET['sender']) ? $_GET['sender'] : 'NONE';
$loc       = isset($_GET['loc']) ? $_GET['loc'] : '0,0';
$address      = isset($_GET['address']) ? $_GET['address'] : 'NO ADDRESS';
$uuid          = isset($_GET['uuid']) ? $_GET['uuid'] : 'NO UUID';
$maj_string      = isset($_GET['maj']) ? $_GET['maj'] : '-1';
$min_string       = isset($_GET['min']) ? $_GET['min'] : '-1';
$rssi       = isset($_GET['rssi']) ? $_GET['rssi'] : 0;
$prox    = isset($_GET['prox']) ? $_GET['prox'] : '0';
$pow      = isset($_GET['pow']) ? $_GET['pow'] : 0;
$t           = isset($_GET['t']) ? $_GET['t'] : '2016-10-10 00:00:00';

$maj = (float)$maj_string;
$min = (float)$min_string;
if($maj >= 0 && $min >= 0)
{
$date=date('Y-m-d H:i:s');

	$student = "UNKNOWN";
	$color = "#000000";
	if($maj_string == 166 && $min == 9){
		$student = "Ron";
	$color = "#00000ff";}
	else if($maj == 177 && $min == 8){
		$student = "Hermione";
	$color = "#00ff00";}
	else if($maj == 177 && $min == 0){
		$student = "Harry";
	$color = "#ffa500";}

	$csv = $sender."|".$date."|".$student."|".$color."|".$loc."|".$address."|".$uuid."|".$maj_string."|".$min_string."|".$rssi."|".$prox."|".$pow."\n";
	file_put_contents('beacon.log',  $csv, FILE_APPEND);
}
?>