<?php
$tel = "15881111";
$senderkey = "7d7181b53eb319a666200b1181dce4a0396b3689";

$to_tel = "821025376460";
$msg = "test message";
$template_code ="J0001";


$url = "https://msg.supersms.co:9443/v1/send/kko";
$data = array(
    "msg_type"=>"AL"
    , "mt_failover"=>"N"
    , "msg_data"=>array(
        "senderid"=>$tel
        , "to" => $to_tel
        ,"content"=>$msg
        )
    , "msg_attr"=>array(
            "sender_key"=>$senderkey
            , "template_code"=>$template_code
            ,"response_method"=>"push"
            ,"ad_flag"=>"N"
            , "button" => array(
                    array(
                        "name"=>"BUTTON1"
                        ,"type"=>"WL"
                        , "url_pc"=>"https://www.kfunding.co.kr"
                        , "url_mobile" =>"https://www.kfunding.co.kr"
                    )
                )
        )

);
$data_string = json_encode($data);
var_dump( kakaotemplate::send('821025376260', 'J0001', array('emoney'=> 1000000)) );

return;
//echo ($data_string); return;
$ret = infokakaoCurl($url, $data_string, $http_status);
if($http_status == 200 ){
    //성공 실패
    $res = json_decode($ret);
    echo $res->messageId;
    echo"<br>";
    echo $res->status;//A000
    echo"<br>";
    echo $res->text;
}
else{
    //실패
    $res = json_decode($ret);
    echo $res->messageId;
    echo"<br>";
    echo $res->status;
    echo"<br>";
    echo $res->text;    
}
/*
$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
    ,'X-IB-Client-Id: kfunding_REST'
    ,'X-IB-Client-Passwd: 5LEvHx0R1C66dorVyWlv'
    , 'Content-Length: ' . strlen($data_string)
    )
);
$result = curl_exec($ch);
curl_close($ch);
var_dump($result);
*/
class kakaotemplate {
    private $cfg;
    public function config()
    {
        $cfg['tel'] = '15881111';
        $cfg['senderkey'] = '7d7181b53eb319a666200b1181dce4a0396b3689';
        $cfg['url'] = 'https://msg.supersms.co:9443/v1/send/kko';
        self::$cfg = '1234';
    }
    public function send( $tel, $templateCode, $data ){
        self::config();
        switch($templateCode){
            case("Enter0001") :
                if( !isset($data['name'])) return false;
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
                if( !isset($data['emoney'])) return false;
                $msg = "케이펀딩 가상계좌로 원리금 ".number_format($data['emoney'])."원이 입급되었습니다.";
                $button = array(
                    "name"=>"정산내역 보기"
                    ,"type"=>"WL"
                    , "url_pc"=>"https://www.kfunding.co.kr/pnpinvest/?mode=mypage_invest_info"
                    , "url_mobile" =>"https://www.kfunding.co.kr/pnpinvest/?mode=mypage_invest_info"
                );                
                break;
            default :
                return false;
            
        }
        //var_dump($this->tel);
        /*
        $data = array(
            "msg_type"=>"AL"
            , "mt_failover"=>"N"
            , "msg_data"=>array(
                "senderid"=>$this->tel
                , "to" => $tel
                ,"content"=>$msg
                )
            , "msg_attr"=>array(
                    "sender_key"=>$this->senderkey
                    , "template_code"=>$templateCode
                    ,"response_method"=>"push"
                    ,"ad_flag"=>"N"
                    , "button" => $button
                )
        );
        */
    }
/*
    public function infokakaoCurl($post_data, &$http_status, &$header = null) {
          $ch=curl_init();
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_URL, $this->url);
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
            //  Log::error("CURL Error: = " . $body);
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
      */
}

class Log {
    public static function debug($str) {
        print "DEBUG: " . $str . "\n";
    }
    public static function info($str) {
        print "INFO: " . $str . "\n";
    }
    public static function error($str) {
        print "ERROR: " . $str . "\n";
    }
}
function infokakaoCurl($url, $post_data, &$http_status, &$header = null) {
  //  Log::debug("Curl $url JsonData=" . $post_data);
    $ch=curl_init();
    // user credencial
    //curl_setopt($ch, CURLOPT_USERPWD, "username:passwd");
    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    // post_data
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    if (!is_null($header)) {
        curl_setopt($ch, CURLOPT_HEADER, true);
    }
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //array('Content-Type: application/json','X-IB-Client-Id: kfunding_REST','X-IB-Client-Passwd: 5LEvHx0R1C66dorVyWlv')
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json','X-IB-Client-Id: kfunding_REST','X-IB-Client-Passwd: 5LEvHx0R1C66dorVyWlv'));
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $response = curl_exec($ch);
    //Log::debug('Curl exec=' . $url);
      
    $body = null;
    // error
    if (!$response) {
        $body = curl_error($ch);
        // HostNotFound, No route to Host, etc  Network related error
        $http_status = -1;
      //  Log::error("CURL Error: = " . $body);
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