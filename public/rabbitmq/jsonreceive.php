<?php
if (php_sapi_name() != 'cli'){echo "FALSE";return;}
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

function sendMessage($message, $to = array()) {
  try{
   $content = array(
     "en" => $message
     );
   $fields = array(
     'app_id' => "6a9495ac-1c17-467e-ba5c-fe59da11a1fe",
     'contents' => $content
   );
   if( isset($to['toid']) ) {
	$fields['include_player_ids'] = $to['toid'];
        echo "to ids \n";	
   }
   else if( isset($to['filter']) ) {
	if( !isset($to['filter']->key) || $to['filter']->key =='' || !isset($to['filter']->value) || $to['filter']->value=='' ) {
		echo "ERROR:filter not set\n";return;
	}
	$fields['filters'] = array(array("field" => "tag", "key" => $to['filter']->key,  "relation" => "=", "value" => $to['filter']->value));
	echo "to FILTERED \n";
   }
   else {
	$fields['included_segments'] = array('All');
	echo "to All \n";
   }

   $fields = json_encode($fields);
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                      'Authorization: Basic NTk5OGUyYzQtODQ3NC00ZDgyLWJjY2QtODE2OTYzODU4NTBi'));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
   curl_setopt($ch, CURLOPT_HEADER, FALSE);
   curl_setopt($ch, CURLOPT_POST, TRUE);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
   $response = curl_exec($ch);
   curl_close($ch);
  }catch(Exception $ex){echo "error";}
 }
#sendMessage('send to id ', array('toid'=>array('e9550dba-2b7c-43ce-bb88-64ee3f6ad5c9')) );
#sendMessage('send ing tag', array('filter'=>array( 'key'=>'userId', 'value'=>'zunme@nate.com')) );
#sendMessage('send to All');

$connection = new AMQPStreamConnection('172.17.0.1', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('SMS', false, true, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
  echo ' [x] Received ', $msg->body, "\n";
  $json = json_decode(stripslashes($msg->body));
  sendMessage ( $json->msg, (is_object($json->to)) ? get_object_vars($json->to):$json->to);
};

$channel->basic_consume('SMS', '', false, true, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}
