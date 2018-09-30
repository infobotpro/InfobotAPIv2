<?php
namespace Infobot\Api;

/**
 * Class Client
 * @package Infobot\Api
 * @method string getMessages(array $params)
 *                  $params => ["getParams" => ["page" => 1]]
 *                  $params => ["getParams" => [":id" => 1]]
 * @method string postMessages(array $params) $params => ["body" => []]
 * @method string getUsers()
 * @method string getScenaries(array $params)
 *                  $params => ["getParams" => ["page" => 1]]
 *                  $params => ["getParams" => [":id" => 1]]
 * @method string getStatisticsVariables(array $params)
 *                  $params => ["getParams" => ["message" => 111]]
 *                  $params => ["getParams" => ["user" => 111]]
 *                  $params => ["getParams" => ["phone" => 111]]
 *                  $params => ["getParams" => ["phone" => 111,"page" => 2]]
 * @method string getCampaigns(array $params)
 *                  $params => ["body" => ["name" => "name of company"]]
 * @method string postCampaigns(array $params)
 *                  $params => ["getParams" => [":id" => 111]]
 * @method string patchCampaigns(array $params)
 *                  $params => ["body" => ["name" => "name of company"]]
 * @method string getStatisticsFinance(array $params)
 *                  $params => ["getParams" => [
 *                                              "overall",":from" => гггг-мм-дд,
 *                                              ":to" => гггг-мм-дд,
 *                                              ":campaign_id" => 10
 *                                             ]
 *                              ]
 * @method string getTrunks(array $params)
 *                  $params => ["getParams" => ["activate"]]
 *                  $params => ["getParams" => [":id" => 1]]
 * @method string postTrunc(array $params)
 *                  $params => ["body" => ["channels"]]
 * @method string deleteTrunc(array  $params)
 *                  $params => ["getParams" => [":id" => 1]]
 * @method string patchTrunc(array $params)
 *                  $params => ["body" => ["channels"]]
 */

class Client
{
    private $token;
    public $response;
    const URL = 'https://client.infobot.pro';
    const URL_API_VERSION = '/api/v2';

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function __call($name, $arguments)
    {
        $name = preg_replace("/([a-z])([A-Z])/","$1 $2",$name);
        $func = explode(" ",$name);

        $additional_url = '';

        $method = strtoupper($func[0]);
        unset($func[0]);
        $func = array_map(function ($val)
        {
            return strtolower($val);
        },$func);
        $main_url = implode("/",$func);

        $url = self::URL.self::URL_API_VERSION."/{$main_url}/{$this->token}";

        if(isset($arguments[0]))
        {
            $func_args = $arguments[0];
            if(is_array($func_args)){
                if(isset($func_args['getParams']))
                {
                    if(!is_array($func_args['getParams']))
                    {
                        throw new \Exception("param [ getParams => [] ] must be array");
                    }
                    foreach($func_args['getParams'] as $key => $val)
                    {
                        if(is_integer($key) || preg_match("(^\:.*$)",$key))
                        {
                            $additional_url .= "/{$val}";
                        }else{
                            $additional_url .= "/{$key}/{$val}";
                        }

                    }
                }
                if(in_array($method,['POST','PATCH']))
                {
                    if(!isset($func_args['body']))
                    {
                        throw new \Exception("param [ body => [] ] is required for method {$method}");
                    }elseif(!is_array($func_args['body']))
                    {
                        throw new \Exception("param [ body => [] ] must be array");
                    }
                }
            }else{
                throw new \Exception("first argument of function must be array");
            }
        }

        if($additional_url)
        {
            $url .= $additional_url;
        }

        return $this->request($method,$url);
    }

    private function request($method, $url, $data = []){

        $curl = curl_init();
        $data = json_encode($data);

        echo "{$method} {$url} {$data}";
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_USERAGENT,'infobot http client v2');
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl,CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);

        switch ($method){
            case "GET" :{
                break;
            }
            case "POST": {
                curl_setopt($curl,CURLOPT_POST,true);
                curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
                break;
            }
            case "PATCH":
            case "DELETE": {
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
                break;
            }
        }

        $response = curl_exec($curl);

        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);

        curl_close($curl);

        if($httpCode == 200)
        {
            $this->response = $response;
            return $response;
        }
        throw new \Exception("Http Error {$httpCode}",$httpCode);
    }

}