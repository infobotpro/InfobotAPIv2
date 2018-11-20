<?php
namespace Infobot\Api;

/**
 * Class Client
 * @package Infobot\Api
 * @method string getMessages(array $params = null)
 * @method string postMessages(array $params)
 * @method string deleteMessages(array $params)
 * @method string getUsers()
 * @method string getScenaries(array $params = null)
 * @method string getStatisticsVariables(array $params)
 * @method string getCampaigns(array  $params = null)
 * @method string postCampaigns(array $params)
 * @method string patchCampaigns(array $params)
 * @method string getStatisticsFinance(array $params)
 * @method string postTrunks(array $params = null)
 * @method string getTrunks(array $params = null)
 * @method string deleteTrunks(array  $params)
 * @method string patchTrunks(array $params)
 * @method string getDeliveries(array $params = null)
 * @method string postDeliveries(array $params)
 * @method string patchDeliveries(array $params)
 * @method string getGroups(array $params = null)
 * @method string postGroups(array $params)
 * @method string patchGroups(array $params)
 * @method string getContacts(array $params = null)
 * @method string postContacts(array $params)
 * @method string patchContacts(array $params)
 *
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
        $data = [];
        if(isset($arguments[0]))
        {
            $func_args = $arguments[0];
            if(is_array($func_args)){
                if(isset($func_args['query']))
                {
                    if(!is_array($func_args['query']))
                    {
                        throw new \Exception("param [ query => [] ] must be array");
                    }
                    foreach($func_args['query'] as $key => $val)
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
                    $data = $func_args['body'];
                }
            }else{
                throw new \Exception("first argument of function must be array");
            }
        }

        if($additional_url)
        {
            $url .= $additional_url;
        }

        return $this->request($method,$url,$data);
    }

    private function request($method, $url, $data = []){

        $curl = curl_init();
        $data = json_encode($data);

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
            return $this->response;
        }
        throw new \Exception("Http Error {$httpCode} {$response}",$httpCode);
    }

}