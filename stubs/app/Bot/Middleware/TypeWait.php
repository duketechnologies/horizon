<?php

namespace App\Bot\Middleware;

use Duke\Horizon\BotMan\BotMan;
use Duke\Horizon\BotMan\Interfaces\Middleware\Sending;

class TypeWait implements Sending
{
    public $count = 0;

    public function sending($payload, $next, BotMan $bot)
    {
        if($this->count == 0) {
            $bot->typesAndWaits(1);
            $this->count++;
        }

        return $next($payload);
    }
}
