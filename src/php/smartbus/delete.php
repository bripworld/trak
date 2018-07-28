<?php 
$fileArray = array(
    "./route.log",
    "./beacon.log",
    "./currentroute.json"
);

foreach ($fileArray as $value) {
    if (file_exists($value)) {
        unlink($value);
    } else {
        // code when file not found
    }
}
?>