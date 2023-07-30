<?php

namespace App\Utils;

use TelegramBot\Api\{BotApi, Types\Message};

class Api extends BotApi
{
    private int $chatId;

    public function __construct($token, $trackerToken = null)
    {
        parent::__construct($token, $trackerToken);
    }

    public function setChatId(int $chatId)
    {
        $this->chatId = $chatId;
    }

    public function sendText(
        string $text,
        string $via = null,
    ): Message
    {
        return parent::sendMessage(
            $this->chatId,
            $text . "\n \n" . ($via ? 'via @' . $via : ''),
            null,
            false,
            null,
            null,
            true,
        );
    }

    public function sendPhotoById(
        string $photoId,
        string $via = null,
    ): Message
    {
        return parent::sendPhoto(
            $this->chatId,
            $photoId,
            $via ? 'via @' . $via : '',
            null,
            null,
            true,
        );
    }

    public function sendVideoById(
        string $videoId,
        string $via = null,
    ): Message
    {
        return parent::sendVideo(
            $this->chatId,
            $videoId,
            null,
            $via ? 'via @' . $via : '',
            null,
            null,
            true,
        );
    }
}
