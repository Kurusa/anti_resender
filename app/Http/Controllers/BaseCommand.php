<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\Api;
use App\Utils\Update;
use Exception;

abstract class BaseCommand
{
    protected Update $update;
    protected $bot;
    protected $user;

    /**
     * @param Update $update
     * @throws Exception
     */
    public function __construct(Update $update)
    {
        $this->update = $update;
        $this->user = User::where('chat_id', $this->update->getBotUser()->getId())->firstOr(function () {
            $this->user = User::create([
                'chat_id'    => $this->update->getBotUser()->getId(),
                'user_name'  => $this->update->getBotUser()->getUsername() ?? $this->update->getBotUser()->getTitle(),
            ]);
        });
    }

    public function getBot(): Api
    {
        if (!$this->bot) {
            $this->bot = new Api(config('app.telegram_bot_token'));
            $this->bot->setChatId($this->update->getBotUser()->getId());
        }

        return $this->bot;
    }

    abstract function handle();
}
