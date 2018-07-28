<?php

require_once 'pushwoosh_inc.php';

use Gomoob\Pushwoosh\Client\Pushwoosh;
use Gomoob\Pushwoosh\Model\Request\CreateMessageRequest;
use Gomoob\Pushwoosh\Model\Notification\Notification;
    
    
$msg      ="Message From Pushwoosh.";
if(isset($_REQUEST["msg"])){
$msg      =isset($_GET['msg']) ? $_GET['msg'] : 'Message From Pushwoosh.';
}
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


// Create a Pushwoosh client
$pushwoosh = Pushwoosh::create()
    ->setApplication('BA5E4-D6CE1')
    ->setAuth('o4jNXf8aJUvRFli59ZShYzowAk682xjprKhLepqqniJa3ydw1IWH7q3REqURyvcRdRClrURFgWKn2wS38cMe');

// Create a request for the '/createMessage' Web Service
$request = CreateMessageRequest::create()
    ->addNotification(Notification::create()->setContent($msg));

// Call the REST Web Service
$response = $pushwoosh->createMessage($request);

// Check if its ok
if($response->isOk()) {
    print 'Great, my message has been sent !';
} else {
    print 'Oops, the sent failed :-('; 
    print 'Status code : ' . $response->getStatusCode();
    print 'Status message : ' . $response->getStatusMessage();
}
?>