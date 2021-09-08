<?php

namespace App\Bot\Conversations;

use Duke\Horizon\BotMan\Messages\Conversations\Conversation;

class AboutPromoConversation extends Conversation
{
    public function run() {
        return $this->say(__('bot.about_promo_text'));
    }
}
