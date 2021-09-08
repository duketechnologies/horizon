<?php

namespace Duke\Horizon\BotMan\Interfaces\Middleware;

use Duke\Horizon\BotMan\BotMan;
use Duke\Horizon\BotMan\Messages\Incoming\IncomingMessage;

interface Received
{
    /**
     * Handle an incoming message.
     *
     * @param IncomingMessage $message
     * @param callable $next
     * @param BotMan $bot
     *
     * @return mixed
     */
    public function received(IncomingMessage $message, $next, BotMan $bot);
}
