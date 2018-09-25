<?php
namespace Infobot\Api;

class Client
{
    private $token;

    const URL = 'https://client.infobot.pro';
    const URL_API = '/api/v2';

    public function __construct($token)
    {
        $this->token = $token;
    }


    private function request($method, $url, $data = []){
        $curl = curl_init();

        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_USERAGENT,'infobot http client v2');

        switch ($method){
            case "GET" : {
                break;
            }
            case "POST": {
                curl_setopt($curl,CURLOPT_POST,true);
                curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
                break;
            }
        }

        $response = curl_exec($curl);

        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);

        curl_close($curl);

        if($httpCode == 200){
            return $response;
        }
        throw new \HttpException("Http Error {$httpCode}",$httpCode);
    }

}