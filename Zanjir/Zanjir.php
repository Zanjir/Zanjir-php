<?php
//////////////////////////
/// We suggest that you read the Zanjir Document before using this library
/// https://github.com/Zanjir/API-Documentation/blob/main/Documentation.md
/// Author : Zanjir Network
/// Website : https://zanjir.network
/////////////////////////
namespace Zanjir;

class Zanjir {

    private static $zanjir_api_url = "https://api.zanjir.network/";

    public function create($params) {
        return Zanjir::_curl("create",$params,"POST");
    }

    public function logs($in_wallet) {
        return Zanjir::_curl("logs",$in_wallet,'GET');
    }

    public function qrcode($params_in_wallet,$amount) {
        $params = $params_in_wallet . "/" . $amount;
        return Zanjir::$zanjir_api_url."qrcode/".$params;
    }
    
    public function qrcode_base64($params_in_wallet,$amount) {
        return 'data:image/gif;base64,' . base64_encode(file_get_contents(Zanjir::qrcode($params_in_wallet,$amount)));
    }
    
    public function coin_list() {
        return  Zanjir::_curl("coin/list",NULL,'GET');
    }

    public function ticker_info($ticker) {
        $coinlists =   Zanjir::coin_list();
        foreach($coinlists as $key => $value){
            if(isset($value->$ticker)){
                return $value->$ticker;
            }
        }
    }

    private static function _curl($endpoint, $params,$method = "POST") {
        $curl = curl_init();
        $CURLOPT_URL = Zanjir::$zanjir_api_url . $endpoint .'/';
        if($method == "GET"){
            $CURLOPT_URL = $CURLOPT_URL .  $params;
            $http_build_query = NULL;
        }else{
            $http_build_query =   http_build_query($params);
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
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

}