<?php

namespace App\Bot\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class ChooseAuthenticationConversation extends Conversation
{
    public function keyboard() {
        return Keyboard::create()->type(Keyboard::TYPE_INLINE)->addRow(
            KeyboardButton::create(__('bot.keyboard.authorization'))->callbackData('/authorization'),
            KeyboardButton::create(__('bot.keyboard.registration'))->callbackData('/registration')
        )->toArray();
    }

    public function run() {
        $this->say(__('bot.choose_auth.alert'), keyboard_back());
        $this->say(__('bot.choose_auth.text'), $this->keyboard());
    }
}
