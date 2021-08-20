<?php

namespace App\Bot\Conversations;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class StartConversation extends Conversation
{
    public function run() {
        $attachment = new Image(env('SITE_URL').'i/og.png?t='.time());

        $message = OutgoingMessage::create()->withAttachment($attachment);
        $this->say($message);

        $message = OutgoingMessage::create(__('bot.start.text'));
        $this->say($message);

        $this->bot->startConversation(new ChooseLanguageConversation());
    }
}
