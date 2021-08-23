<?php

namespace App\Bot\Middleware;

use App\Bot\ApiService;
use App\Bot\Conversations\ChooseAuthenticationConversation;
use BotMan\Drivers\Telegram\TelegramDriver;
use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function check_for_login($string)
    {
        $array_command = [
            __('bot.menu.profile'),
            __('bot.menu.start_action'),
            __('bot.menu.start_game'),
            __('bot.menu.take_prize'),
            __('bot.menu.send_question'),
        ];
        foreach ($array_command as $command) if(str_contains($string, $command))return true;
        return false;
    }

    public function handle(Request $request, Closure $next)
    {
        $message_text = $request->input('message.text');
        if($message_text && $this->check_for_login($message_text) && !ApiService::userLogin()) {
            $bot = botman_create();
            return $bot->startConversation(new ChooseAuthenticationConversation(), chat_id(), TelegramDriver::class);
        }
        return $next($request);
    }
}