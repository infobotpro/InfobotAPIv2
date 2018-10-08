<?php
namespace Infobot\Api\Trunks;

class BaseTrunk {
    public $channels;
    public $host;
    public $login;
    public $password;
    public $title;

    public function __construct($params)
    {
        foreach ($params as $key => $val){
            $this->$key = $val;
        }
    }

    public function toArray(){
        return get_object_vars($this);
    }
}