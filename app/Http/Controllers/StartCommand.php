<?php

namespace App\Http\Controllers;

class StartCommand extends BaseCommand
{
    public function handle()
    {
        $this->getBot()->sendText(
            'Вітаю. Ви можете додати мене у групу або канал як адміністратора, ' .
            'де я буду наглядати за пересланими повідомленнями і відправляти їх від свого імені'
        );
    }
}
