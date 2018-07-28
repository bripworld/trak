<?php


require_once 'Gomoob/Pushwoosh/ICURLClient.php';
require_once 'Gomoob/Pushwoosh/IPushwoosh.php';
require_once 'Gomoob/Pushwoosh/JsonUtils.php';

require_once 'Gomoob/Pushwoosh/Client/CURLClient.php';
require_once 'Gomoob/Pushwoosh/Client/Pushwoosh.php';
require_once 'Gomoob/Pushwoosh/Client/PushwooshMock.php';

require_once 'Gomoob/Pushwoosh/Curl/ICurlRequest.php';
require_once 'Gomoob/Pushwoosh/Curl/CurlRequest.php';

require_once 'Gomoob/Pushwoosh/Exception/PushwooshException.php';

require_once 'Gomoob/Pushwoosh/Model/IRequest.php';
require_once 'Gomoob/Pushwoosh/Model/IResponse.php';

require_once 'Gomoob/Pushwoosh/Model/Condition/ICondition.php';
require_once 'Gomoob/Pushwoosh/Model/Condition/AbstractCondition.php';
require_once 'Gomoob/Pushwoosh/Model/Condition/DateCondition.php';
require_once 'Gomoob/Pushwoosh/Model/Condition/ListCondition.php';
require_once 'Gomoob/Pushwoosh/Model/Condition/StringCondition.php';
require_once 'Gomoob/Pushwoosh/Model/Condition/IntCondition.php';


require_once 'Gomoob/Pushwoosh/Model/Notification/ADM.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/Android.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/BlackBerry.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/Chrome.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/Firefox.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/IOS.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/Mac.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/MinimizeLink.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/Notification.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/Platform.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/Safari.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/WNS.php';
require_once 'Gomoob/Pushwoosh/Model/Notification/WP.php';

require_once 'Gomoob/Pushwoosh/Model/Request/AbstractRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Request/CreateMessageRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Request/CreateTargetedMessageRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Request/DeleteMessageRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Request/GetNearestZoneRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Request/GetTagsRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Request/PushStatRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Request/RegisterDeviceRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Request/SetBadgeRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Request/SetTagsRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Request/UnregisterDeviceRequest.php';
require_once 'Gomoob/Pushwoosh/Model/Response/AbstractResponse.php';

require_once 'Gomoob/Pushwoosh/Model/Response/CreateMessageResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/CreateMessageResponseResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/CreateTargetedMessageResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/CreateTargetedMessageResponseResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/DeleteMessageResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/GetNearestZoneResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/GetNearestZoneResponseResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/GetTagsResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/GetTagsResponseResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/PushStatResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/RegisterDeviceResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/SetBadgeResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/SetTagsResponse.php';
require_once 'Gomoob/Pushwoosh/Model/Response/UnregisterDeviceResponse.php';

use Gomoob\Pushwoosh\Client\Pushwoosh;
use Gomoob\Pushwoosh\Model\Request\CreateMessageRequest;
use Gomoob\Pushwoosh\Model\Notification\Notification;
    
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


// Create a Pushwoosh client
$pushwoosh = Pushwoosh::create()
    ->setApplication('BA5E4-D6CE1')
    ->setAuth('o4jNXf8aJUvRFli59ZShYzowAk682xjprKhLepqqniJa3ydw1IWH7q3REqURyvcRdRClrURFgWKn2wS38cMe');

// Create a request for the '/createMessage' Web Service
$request = CreateMessageRequest::create()
    ->addNotification(Notification::create()->setContent('Alert From SmartBus-SG'));

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