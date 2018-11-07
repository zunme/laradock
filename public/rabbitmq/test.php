<?php
//kakao
$url = "https://msg.supersms.co:9443/v1/send/kko";
$header = array(
		'Content-Type: application/json; charset=utf-8',
		'X-IB-Client-Id: kfunding', 
		'X-IB-Client-Passwd: rdNGE9MDuI7po6eCOi3A'
	);
$friendkey ="";
$postfield = array(
  "msg_type"=> "AL",
  "mt_failover"=> "N",
  "msg_data"=>array(
		"senderid"=> "15881234",
		"to"=> "821012345678",
		"content"=> "TEST MESSAGE"
    	 ), 
  "msg_attr" = array(
    "sender_key"=> $friendkey,
    "template_code" : "1234",
    "response_method": "push",
    "ad_flag": "Y",
    "button" => 
      array(
    		 array(
           "name": "BUTTON1"
	       "type": "WL",
	       "url_pc": "http://www.kakao.com",
	       "url_mobile": "http://www.kakao.com"
    		 ),
        	array(
           "name": "BUTTON1"
	       "type": "WL",
	       "url_pc": "http://www.kakao.com",
	       "url_mobile": "http://www.kakao.com"
    		 )
       ),//msg_attr
);
//var_dump($postfield);
var_dump(json_encode($postfield) );