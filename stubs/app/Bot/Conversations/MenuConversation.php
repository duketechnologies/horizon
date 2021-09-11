<?php

namespace App\Bot\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\TelegramExtensions\Keyboard;
use BotMan\Drivers\TelegramExtensions\KeyboardButton;
use Spatie\Emoji\Emoji;

class MenuConversation extends Conversation
{
    public function keyboard()
    {
        $profile = KeyboardButton::create(Emoji::fileFolder().' '.__('bot.menu.profile'));
        $start_action = KeyboardButton::create(Emoji::receipt().' '.__('bot.menu.start_action'));
        $rules = KeyboardButton::create(Emoji::pageFacingUp().' '.__('bot.menu.rules'));
        $about_promo = KeyboardButton::create(Emoji::collision().' '.__('bot.menu.about_promo'));
        $winners = KeyboardButton::create(Emoji::trophy().' '.__('bot.menu.winners'));
        $send_question = KeyboardButton::create(Emoji::exclamationQuestionMark().' '.__('bot.menu.send_question'));
        $site_link = KeyboardButton::create(Emoji::globeWithMeridians().' '.__('bot.menu.site_link'));
        $language =  KeyboardButton::create((app()->getLocale() == 'ru' ? Emoji::flagsForFlagRussia() : Emoji::flagsForFlagKazakhstan()).' '.__('bot.menu.language'));

        return Keyboard::create()
            ->type(Keyboard::TYPE_KEYBOARD)
            ->resizeKeyboard()
            ->addRow($profile)
            ->addRow($start_action, $rules)
            ->addRow($about_promo, $winners)
            ->addRow($send_question, $site_link)
            ->addRow($language)
            ->toArray();
    }

    public function run()
    {
        return $this->say(__('bot.menu_text'), $this->keyboard());
    }
}
