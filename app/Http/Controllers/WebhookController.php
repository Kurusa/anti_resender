<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Update;

class WebhookController
{
    public function handle()
    {
        $client = new Client(config('app.telegram_bot_token'));

        $client->on(function (Update $update) {
        }, function (Update $update) {
            $commandHandler = null;

            if ($update->getChannelPost()) {
                if ($update->getChannelPost()->getForwardDate()) {
                    $commandHandler = ResendCommand::class;
                }
            } else if ($update->getMessage()) {
                if (
                    $update->getMessage()->getChat()->getType() === 'group' ||
                    $update->getMessage()->getChat()->getType() === 'supergroup'
                ) {
                    if ($update->getMessage()->getForwardDate()) {
                        $commandHandler = ResendCommand::class;
                    }
                } else if ($update->getMessage()->getText() === '/start') {
                    $commandHandler = StartCommand::class;
                }
            }

            if ($commandHandler) {
                (new $commandHandler (new \App\Utils\Update($update)))->handle();
            }

            return 200;
        });

        $client->run();
    }
}
