<?php

namespace Duke\Horizon\BotMan\Interfaces;

use Duke\Horizon\BotMan\Interfaces\Middleware\Captured;
use Duke\Horizon\BotMan\Interfaces\Middleware\Heard;
use Duke\Horizon\BotMan\Interfaces\Middleware\Matching;
use Duke\Horizon\BotMan\Interfaces\Middleware\Received;
use Duke\Horizon\BotMan\Interfaces\Middleware\Sending;

interface MiddlewareInterface extends Captured, Received, Matching, Heard, Sending
{
    //
}
