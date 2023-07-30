<?php

namespace App\Utils;

use Exception;
use TelegramBot\Api\Types\Chat;
use TelegramBot\Api\Types\User;

class Update extends \TelegramBot\Api\Types\Update
{
    public function __construct(\TelegramBot\Api\Types\Update $update)
    {
        if ($update->getCallbackQuery()) {
            parent::setCallbackQuery($update->getCallbackQuery());
        }

        if ($update->getMessage()) {
            parent::setMessage($update->getMessage());
        }

        if ($update->getChannelPost()) {
            parent::setChannelPost($update->getChannelPost());
        }
    }

    public function getBotUser(): User|Chat
    {
        if ($this->getCallbackQuery()) {
            $user = $this->getCallbackQuery()->getFrom();
        } elseif ($this->getMessage()) {
            if (
                $this->getMessage()->getChat()->getType() === 'group' ||
                $this->getMessage()->getChat()->getType() === 'supergroup'
            ) {
                $user = $this->getMessage()->getChat();
            } else {
                $user = $this->getMessage()->getFrom();
            }
        } elseif ($this->getInlineQuery()) {
            $user = $this->getInlineQuery()->getFrom();
        } elseif ($this->getChannelPost()) {
            $user = $this->getChannelPost()->getChat();
        } else {
            throw new Exception('cant get telegram user data');
        }

        return $user;
    }
}
