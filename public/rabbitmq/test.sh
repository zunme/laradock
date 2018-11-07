curl -v -X POST https://msg.supersms.co:9443/v1/send/kko \
-H 'X-IB-Client-Id: kfunding' \
-H 'X-IB-Client-Passwd: rdNGE9MDuI7po6eCOi3A' \
-H 'Content-type: application/json' -d '{ \
 "msg_type": "AL", \
 "mt_failover": "N", \
 "msg_data": { \
  "senderid": "15881234", \
  "to": "821012345678", \
  "content": "TEST MESSAGE" \
  }, \
   "msg_attr": { \
    "sender_key": "7d7181b53eb319a666200b1181dce4a0396b3689", \
    "template_code" : "1234", \
    "response_method": "push", \
    "ad_flag": "Y", \
     "button":  \
       { \
       "name": "BUTTON1" \
       "type": "WL", \
       "url_pc": "http://www.kakao.com", \
       "url_mobile": "http://www.kakao.com" \
       }, \
       { \
       "name": " BUTTON2", \
       "type": "MD" \
       }, \
       { \
       "name": " BUTTON3", \
       "type": "AL \
       "scheme_ios": "daumapps://open", \
       "scheme_android": "daumapps://open" \
       }, \
     ], \
     "image": { \
      "img_url":"http://mud-kage.kakao.com/dn/6Q8V8/btqg8nla99S/qft1caHh7eqA44HRysdk70/img_l.png",  \
      "img_link": "http://bizmessage.kakao.com/" \
     } \
    } \
   } \
  }'
