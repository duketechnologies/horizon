<?php

namespace Duke\Horizon\BotMan\Traits;

use Duke\Horizon\BotMan\Interfaces\ExceptionHandlerInterface;

trait HandlesExceptions
{
    /**
     * Register a custom exception handler.
     *
     * @param string $exception
     * @param callable $closure
     */
    public function exception(string $exception, $closure)
    {
        $this->exceptionHandler->register($exception, $this->getCallable($closure));
    }

    /**
     * @param ExceptionHandlerInterface $exceptionHandler
     */
    public function setExceptionHandler(ExceptionHandlerInterface $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }
}
