<?php

?>
<!DOCTYPE html>
<html>
	<head>
		<title>File Browser</title>
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
		</style>
		<!--[if !IE]><!-->
    <script src="/pushwoosh-web-pushes-http-sdk.js?pw_application_code=BA5E4-D6CE1"></script>
<!--<![endif]-->
	</head>
	<body><script>pushwoosh.subscribeAtStart();</script>
		<h4>All Files</h4>
</div>
    <?php
    foreach (glob("*.*") as $filename) {
        echo "<a href='" . $filename ."'>". $filename ."</a><br/>"; 
    }
    ?>

	</body>
</html>