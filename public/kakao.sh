curl -v --http1.1 --tlsv1.1 -X POST -H 'X-IB-Client-Id: kfunding' -H 'X-IB-Client-Passwd: rdNGE9MDuI7po6eCOi3A' \
-H 'Content-type: application/json' -d '{\
 "msg_type": "AL",\
 "mt_failover": "N"\,
 "msg_data": {\
  "senderid": "15881234",\
  "to": "821025376460",\
  "content": "TEST MESSAGE"\
  },\
   "msg_attr": {\
    "sender_key": "7d7181b53eb319a666200b1181dce4a0396b3689",\
    "template_code" : "1234",\
    "response_method": "push",\
    "ad_flag": "N",\
     "button": [\
       {\
       "name": "BUTTON1"\
       "type": "WL",\
       "url_pc": "https://www.kfunding.co.kr",\
       "url_mobile": "https://www.kfunding.co.kr"\
       }\
     ],\
     "image": {\
      "img_url":"http://mud-kage.kakao.com/dn/6Q8V8/btqg8nla99S/qft1caHh7eqA44HRysdk70/img_l.png",\
      "img_link": "http://bizmessage.kakao.com/"\
     }\
    }\
   }\
  }' 'https://msg.supersms.co:9443/v1/send/kko'
