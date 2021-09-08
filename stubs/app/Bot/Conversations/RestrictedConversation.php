<?php

namespace App\Bot\Conversations;

use Duke\Horizon\BotMan\Messages\Conversations\Conversation;
use Duke\Horizon\BotMan\Messages\Incoming\Answer;
use Duke\Horizon\BotMan\Drivers\Telegram\Extensions\Keyboard;
use Duke\Horizon\BotMan\Drivers\Telegram\Extensions\KeyboardButton;

class RestrictedConversation extends Conversation
{
    public function keyboard_age()
    {
        return Keyboard::create()
            ->type(Keyboard::TYPE_INLINE)
            ->addRow(
                KeyboardButton::create(__('bot.keyboard.yes'))->callbackData('yes'),
                KeyboardButton::create(__('bot.keyboard.no'))->callbackData('no')
            )
            ->toArray();
    }

    public function ask_age()
    {
        $this->ask(__('bot.ask.age'), function (Answer $answer) {
            if ($answer->getValue() == 'yes') return $this->bot->startConversation(new ChooseLanguageConversation());
            if ($answer->getValue() == 'no') $this->say(__('bot.start.restricted'));
            return $this->repeat();
        }, $this->keyboard_age());
    }

    public function run()
    {
        $this->ask_age();
    }
}
