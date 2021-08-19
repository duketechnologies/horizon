<?php

namespace App\Bot\Middleware;

use App\Bot\Conversations\ChooseAuthenticationConversation;
use Bot\ApiService;
use BotMan\BotMan\Interfaces\Middleware\Matching;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\Drivers\Telegram\TelegramDriver;

class CheckAuth implements Matching
{
    public function matching(IncomingMessage $message, $pattern, $regexMatched)
    {
        if (!ApiService::userLogin(user_storage())) {
            $bot = botman_create();
            $bot->startConversation(new ChooseAuthenticationConversation(), $message->getSender(), TelegramDriver::class);
            $bot->removeStoredConversation();
            return false;
        }

        return $regexMatched;
    }
}
