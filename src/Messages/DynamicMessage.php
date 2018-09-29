<?php
namespace Infobot\Api\Messages;

class DynamicMessage extends BaseMessage {

    public $scenary;

    public function __construct($params)
    {
        parent::__construct($params);
        $this->type = BaseMessage::TYPE_STATIC;
    }

    public function required()
    {
        return array_merge(parent::required(),[
            'scenary'
        ]);
    }
}