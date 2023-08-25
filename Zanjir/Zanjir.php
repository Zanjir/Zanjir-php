<?php
//////////////////////////
/// We suggest that you read the Zanjir Document before using this library
/// https://github.com/Zanjir/API-Documentation/blob/main/Documentation.md
/// Author : Zanjir Network
/// Website : https://zanjir.network
/// Version : 2.0
/////////////////////////
namespace Zanjir;

define("ZANJIR_API_URL", "https://gate.zanjir.network/api/");
class Zanjir {

    public function create(Array $params) {
        return Zanjir::_curl("create",$params,"POST");
    }

    public function verify(String $id) {
        return Zanjir::_curl("verify",$id,'GET');
    }
    
    private static function _curl($endpoint, $params,$method = "POST") {
        $curl = curl_init();
        $CURLOPT_URL = ZANJIR_API_URL . $endpoint .'/';
        if($method == "GET"){
            $CURLOPT_URL = $CURLOPT_URL .  $params;
            $http_build_query = NULL;
        }else{
            $http_build_query =   json_encode($params);
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $CURLOPT_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $http_build_query,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

}
