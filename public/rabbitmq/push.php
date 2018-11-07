<?php
function sendMessage($message, $to = array()) {
   $content = array(
     "en" => $message
     );
   $fields = array(
     'app_id' => "6a9495ac-1c17-467e-ba5c-fe59da11a1fe",
     //'included_segments' => $to,
     //'include_player_ids'=>$toid,
     //'filters'=>$filters,
     'contents' => $content
   );
   if( isset($to['toid']) ) $fields['include_player_ids'] = $to['toid'];
   else if( isset($to['filter']) ) $fields['filters'] = array(array("field" => "tag", "key" => $to['filter']['key'],  "relation" => "=", "value" => $to['filter']['value']));
   else $fields['included_segments'] = array('All');

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
   return $response;
 }
#sendMessage('send to id ', array('toid'=>array('e9550dba-2b7c-43ce-bb88-64ee3f6ad5c9')) );
#sendMessage('send ing tag', array('filter'=>array( 'key'=>'userId', 'value'=>'zunme@nate.com')) );
#sendMessage('send to All');
