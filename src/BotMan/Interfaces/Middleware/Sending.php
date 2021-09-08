<?php

namespace Duke\Horizon\BotMan\Interfaces\Middleware;

use Duke\Horizon\BotMan\BotMan;

interface Sending
{
    /**
     * Handle an outgoing message payload before/after it
     * hits the message service.
     *
     * @param mixed $payload
     * @param callable $next
     * @param BotMan $bot
     *
     * @return mixed
     */
    public function sending($payload, $next, BotMan $bot);
}
