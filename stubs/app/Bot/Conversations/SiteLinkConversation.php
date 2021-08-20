<?php

namespace App\Bot\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class SiteLinkConversation extends Conversation
{
    public function keyboard() {
        $site_url = env('SITE_URL');

        return Keyboard::create()->type(Keyboard::TYPE_INLINE)->addRow(
            KeyboardButton::create($site_url)->url($site_url)
        )->toArray();
    }

    public function run() {
        return $this->say(__('bot.site_link_text'), $this->keyboard());
    }
}
