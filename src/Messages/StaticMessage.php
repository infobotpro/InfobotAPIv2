<?php
namespace Infobot\Api\Messages;

class StaticMessage extends BaseMessage {

    public $text;
    public $tts_voice;
    public $tts_speed;

    public function __construct($params)
    {
        parent::__construct($params);
        $this->type = BaseMessage::TYPE_STATIC;
    }

    public function required()
    {
        return array_merge(parent::required(),[
            'text'
        ]);
    }
}