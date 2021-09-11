<?php

namespace App\Bot\Conversations;

use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Spatie\Emoji\Emoji;

class RulesConversation extends Conversation
{
    public function run() {
        $attachment = new File(rules_url());
        $message = OutgoingMessage::create(Emoji::pageFacingUp() .' '. __('bot.ask.rules'))->withAttachment($attachment);

        $this->say($message);
    }
}
