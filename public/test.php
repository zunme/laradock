<?php
class infokakao {
    public static $cfg;
    function __construct( $cfg=array() ){
        self:: set($cfg);
    }
    function infokakao ( $cfg=array() ){
        self:: set($cfg);
    }
    function set($cfg=array() ){
        $cfg['tel'] = isset($cfg['tel'])&& $cfg['tel'] !='' ? $cfg['tel'] : '15881111';
        $cfg['senderkey'] = isset($cfg['senderkey'])&& $cfg['senderkey'] !='' ? $cfg['senderkey'] : '7d7181b53eb319a666200b1181dce4a0396b3689';
        $cfg['url'] = isset($cfg['url'])&& $cfg['url'] !='' ? $cfg[''] : 'https://msg.supersms.co:9443/v1/send/kko';
        self::$cfg = $cfg;
    }
    function send($tel, $templateCode, $data ){
        if(self::$cfg == null ) self::set();
        $hp = preg_replace("/[^0-9]/", "", $tel);
        if(preg_match("/^01[0-9]{8,9}$/", $hp)){
            $tel = ( '821'.substr($hp, 2));
        }else if(preg_match("/^821[0-9]{8,9}$/", $hp)) {
            $tel = $hp;
        }else return array('code' => -1 , 'messageId'=>'', 'to'=>$tel, 'status'=>'ERROR003', 'text'=>'hp check false');
        var_dump($tel);
        return;
        switch($templateCode){
            case("Enter0001") :
                if( !isset($data['name'])) return array('code' => -1 , 'messageId'=>'', 'to'=>$tel, 'status'=>'ERROR001', 'text'=>'REQUIRED VALUE');
                $msg = "안녕하세요. ".$data['name']." 고객님

                (주)케이펀딩에 가입해주셔서 감사합니다.
                투자자정보 등록후 케이펀딩의 투자에 참여하실수 있습니다.
                
                기타문의 사항은 고객센터 02-552-1772로 연락주시기 바랍니다.
                
                감사드립니다. 
                케이펀딩 드림";
                $button = array(
                    "name"=>"케이펀딩 바로가기"
                    ,"type"=>"WL"
                    , "url_pc"=>"http://www.kfunding.co.kr"
                    , "url_mobile" =>"http://www.kfunding.co.kr"
                );
                break;
            case("J0001") :
                if( !isset($data['emoney'])) return array('code' => -1 , 'messageId'=>'', 'to'=>$tel, 'status'=>'ERROR001', 'text'=>'REQUIRED VALUE');
                $msg = "케이펀딩 가상계좌로 원리금 ".number_format($data['emoney'])."원이 입급되었습니다.";
                $button = array(
                    "name"=>"정산내역 보기"
                    ,"type"=>"WL"
                    , "url_pc"=>"https://www.kfunding.co.kr/pnpinvest/?mode=mypage_invest_info"
                    , "url_mobile" =>"https://www.kfunding.co.kr/pnpinvest/?mode=mypage_invest_info"
                );                
                break;
            default :
                return array('code' => -1 , 'messageId'=>'', 'to'=>$tel, 'status'=>'ERROR002', 'text'=>'Template Code');
            
        }
        
        $data = array(
            "msg_type"=>"AL"
            , "mt_failover"=>"N"
            , "msg_data"=>array(
                "senderid"=>self::$cfg['tel']
                , "to" => $tel
                ,"content"=>$msg
                )
            , "msg_attr"=>array(
                    "sender_key"=>self::$cfg['senderkey']
                    , "template_code"=>$templateCode
                    ,"response_method"=>"push"
                    ,"ad_flag"=>"N"
                    , "button" => $button
                )
        );
        $body = self::infokakaoCurl(json_encode($data) ,$http_status);
        if( $http_status > 0){
            $ret = json_decode(html_entity_decode($body), TRUE);
            $ret['code'] = $http_status;
        }else {
            $ret['code'] = $http_status;
            $ret['messageId']='';
            $ret['to']= $tel;
            $ret['status']= 'ERROR';
            $ret['text']= 'NETWORK ERROR';
        }
        $ret['msg'] = $msg;
        //return (array('status'=>$http_status, 'body'=>$body) );
        return $ret;
    }
    function infokakaoCurl($post_data, &$http_status, &$header = null) {
          $ch=curl_init();
          // user credencial
          //curl_setopt($ch, CURLOPT_USERPWD, "username:passwd");
          //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_URL, self::$cfg['url']);
          // post_data
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
          if (!is_null($header)) {
              curl_setopt($ch, CURLOPT_HEADER, true);
          }
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json','X-IB-Client-Id: kfunding_REST','X-IB-Client-Passwd: 5LEvHx0R1C66dorVyWlv'));
          curl_setopt($ch, CURLOPT_VERBOSE, true);
          $response = curl_exec($ch);
            
          $body = null;
          // error
          if (!$response) {
              $body = curl_error($ch);
              // HostNotFound, No route to Host, etc  Network related error
              $http_status = -1;
          } else {
             //parsing http status code
              $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
              if (!is_null($header)) {
                  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                  $header = substr($response, 0, $header_size);
                  $body = substr($response, $header_size);
              } else {
                  $body = $response;
              }
          }
          curl_close($ch);
          return $body;
      }
}
class alimtok extends infokakao {
    function getData(){
        try 
        {
            $pdo = new PDO('mysql:host=112.175.14.20;dbname=user01', 'user01', 'user015754!@#');
        }
        catch (PDOException $e) 
        {
            echo 'Error: ' . $e->getMessage();
            return;
        }
        echo "DB connedcted";
    }
    function setData() {
        try 
        {
            $pdo = new PDO('mysql:host=112.175.14.20;dbname=user01', 'user01', 'user015754!@#');
        }
        catch (PDOException $e) 
        {
            echo 'Error: ' . $e->getMessage();
            return;
        }        
    }
}
alimtok::getData();
//var_dump( infokakao::send('010-25376460', 'J0001', array('emoney'=> 1000000)) );
