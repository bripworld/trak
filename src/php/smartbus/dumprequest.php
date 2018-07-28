<?php 
$req_dump = print_r( $_REQUEST, true );
$fp = file_put_contents( 'request.log', $req_dump, FILE_APPEND  );
?>
