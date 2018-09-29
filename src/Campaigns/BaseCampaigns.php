<?php
namespace Infobot\Api\Campaigns;

class BaseCampaigns {
    public $name;

    public function __construct($name)
    {
        $this->name;
    }

    public function toArray(){
        return get_object_vars($this);
    }
}