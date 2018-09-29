<?php
namespace Infobot\Api\Messages;

class AudioMessage extends BaseMessage {

    public $audio;

    public function __construct($params)
    {
        parent::__construct($params);
        $this->type = BaseMessage::TYPE_AUDIO;
    }

    public function required()
    {
        return array_merge(parent::required(),[
            'audio'
        ]);
    }
}