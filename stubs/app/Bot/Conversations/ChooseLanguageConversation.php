<?php

namespace App\Bot\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\Drivers\TelegramExtensions\Keyboard;
use BotMan\Drivers\TelegramExtensions\KeyboardButton;

class ChooseLanguageConversation extends Conversation
{
    public function keyboard() {
        return Keyboard::create()->type(Keyboard::TYPE_INLINE)->addRow(
            KeyboardButton::create('Русский')->callbackData('ru'),
            KeyboardButton::create('Казакша')->callbackData('kk')
        )->toArray();
    }

    public function run() {
        return $this->ask(__('bot.choose_language.text'), function(Answer $answer) {
            if ($answer->getValue()) {
                app()->setLocale($answer->getValue());
                user_storage()->set('lang', $answer->getValue());

                return $this->bot->startConversation(new MenuConversation());
            }
            else $this->repeat();
        }, $this->keyboard());
    }
}
