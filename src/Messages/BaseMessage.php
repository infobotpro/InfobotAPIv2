<?php
namespace Infobot\Api\Messages;

class BaseMessage {
    public $to;
    public $type;
    public $callerid;
    public $at;
    public $time_to_send_start;
    public $time_to_send_end;
    public $client_timezone;
    public $detect_voicemail;
    public $campaign_id;
    public $trunk;
    public $custom_id;
    public $callback;
    public $try_count;
    public $try_timeout;
    public $variables;

    const TYPE_STATIC = 'static';
    const TYPE_AUDIO = 'audio';
    const TYPE_DYNAMIC = 'dynamic';

    public function __construct($params)
    {
        if(!is_array($params)){
            throw new \Exception("arg [params] must be array");
        }
        foreach ($params as $key => $val){
            $this->$key = $val;
        }
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function toArray(){
        $vars = get_object_vars($this);
        foreach ($vars as $key => $val){
            if(is_null($val)){
                if(in_array($key,$this->required())){
                   throw new \Exception("param {$key} is required");
                }
                unset($vars[$key]);
            }

        }
        return $vars;
    }

    public function required(){
        return [
            'to',
            'type',
        ];
    }
}