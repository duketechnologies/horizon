<?php

namespace App\Bot\Conversations;

use Duke\Horizon\BotMan\Messages\Attachments\File;
use Duke\Horizon\BotMan\Messages\Conversations\Conversation;
use Duke\Horizon\BotMan\Messages\Outgoing\OutgoingMessage;
use Spatie\Emoji\Emoji;

class RulesConversation extends Conversation
{
    public function run() {
        $attachment = new File(rules_url());
        $message = OutgoingMessage::create(Emoji::pageFacingUp() .' '. __('bot.ask.rules'))->withAttachment($attachment);

        $this->say($message);
    }
}
