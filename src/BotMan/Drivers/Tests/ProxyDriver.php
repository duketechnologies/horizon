<?php

namespace Duke\Horizon\BotMan\Drivers\Tests;

use Duke\Horizon\BotMan\Drivers\NullDriver;
use Duke\Horizon\BotMan\Http\Curl;
use Duke\Horizon\BotMan\Interfaces\DriverInterface;
use Duke\Horizon\BotMan\Messages\Incoming\IncomingMessage;
use Symfony\Component\HttpFoundation\Request;

/**
 * A driver that acts as a proxy for a global driver instance. Useful for mock/fake drivers in integration tests.
 */
final class ProxyDriver implements DriverInterface
{
    /**
     * @var DriverInterface
     */
    private static $instance;

    /**
     * Set driver instance to be used.
     *
     * @param DriverInterface $driver
     */
    public static function setInstance(DriverInterface $driver)
    {
        self::$instance = $driver;
    }

    /**
     * @return DriverInterface
     */
    private static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new NullDriver(new Request, [], new Curl);
        }

        return self::$instance;
    }

    public function matchesRequest()
    {
        return self::instance()->matchesRequest();
    }

    public function hasMatchingEvent()
    {
        return self::instance()->hasMatchingEvent();
    }

    public function getMessages()
    {
        return self::instance()->getMessages();
    }

    public function isBot()
    {
        return self::instance()->isBot();
    }

    public function isConfigured()
    {
        return self::instance()->isConfigured();
    }

    public function getUser(IncomingMessage $matchingMessage)
    {
        return self::instance()->getUser($matchingMessage);
    }

    public function getUserWithFields(array $fields, IncomingMessage $matchingMessage)
    {
        return self::instance()->getUser($matchingMessage);
    }

    public function getConversationAnswer(IncomingMessage $message)
    {
        return self::instance()->getConversationAnswer($message);
    }

    public function buildServicePayload($message, $matchingMessage, $additionalParameters = [])
    {
        return self::instance()->buildServicePayload($message, $matchingMessage, $additionalParameters);
    }

    public function sendPayload($payload)
    {
        return self::instance()->sendPayload($payload);
    }

    public function getName()
    {
        return self::instance()->getName();
    }

    public function types(IncomingMessage $matchingMessage)
    {
        return self::instance()->types($matchingMessage);
    }

    /**
     * Tells if the stored conversation callbacks are serialized.
     *
     * @return bool
     */
    public function serializesCallbacks()
    {
        return self::instance()->serializesCallbacks();
    }
}
