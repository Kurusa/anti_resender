<?php

namespace App\Http\Controllers;

class ResendCommand extends BaseCommand
{
    public function handle()
    {
        $message = $this->update->getChannelPost() ?? $this->update->getMessage();
        $via = $this->update->getMessage()?->getFrom()->getUsername();

        if ($photos = $message->getPhoto()) {
            $this->getBot()->sendPhotoById($photos[0]->getFileId(), $via);
        }

        if ($video = $message->getVideo()) {
            $this->getBot()->sendVideoById($video->getFileId(), $via);
        }

        if ($text = $message->getText()) {
            $this->getBot()->sendText($text, $via);
        }

        $this->getBot()->deleteMessage($this->user->chat_id, $message->getMessageId());
    }
}
