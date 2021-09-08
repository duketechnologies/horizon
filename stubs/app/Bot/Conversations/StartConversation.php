<?php

namespace App\Bot\Conversations;

use Duke\Horizon\BotMan\Messages\Attachments\Image;
use Duke\Horizon\BotMan\Messages\Conversations\Conversation;
use Duke\Horizon\BotMan\Messages\Outgoing\OutgoingMessage;

class StartConversation extends Conversation
{
    public function run() {
        $attachment = new Image(env('SITE_URL').'i/og.png?t='.time());

        $message = OutgoingMessage::create()->withAttachment($attachment);
        $this->say($message);

        $message = OutgoingMessage::create(__('bot.start.text'));
        $this->say($message);

        $this->bot->startConversation(new RestrictedConversation());
    }
}
