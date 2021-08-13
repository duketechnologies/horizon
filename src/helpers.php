<?php

use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use Duke\Horizon\Rules\TelegramTextChecker;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use Spatie\Emoji\Emoji;

if (! function_exists('botman_create')) { // Create a new BotMan instance.
    function botman_create() {
        $config = config('botman');
        DriverManager::loadDriver(TelegramDriver::class);
        return BotManFactory::create($config, new LaravelCache());
    }
}

if (! function_exists('message_chat')) { // Get chat data from request
    function message_chat() {
        return request()->input('message.chat') ?? request()->input('callback_query.message.chat');
    }
}

if (! function_exists('rules_url')) {
    function rules_url() {
        return env('APP_URL').'docs/rules_'.app()->getLocale().'.pdf?t='.time();
    }
}

if (! function_exists('remove_emoji')) {
    function remove_emoji($string) {
        return preg_replace('%(?:
              \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
        )%xs', '', iconv("UTF-8", "UTF-8//IGNORE", $string));
    }
}

if (! function_exists('validate_field')) {
    function validate_field($field, $value, $rules = []) {
        $data = [$field => $value];

        return Validator::make($data, [
            $field => array_merge($rules, ['required', new TelegramTextChecker()])
        ]);
    }
}

if (! function_exists('keyboard_back')) {
    function keyboard_back() {
        return Keyboard::create()
            ->type(Keyboard::TYPE_KEYBOARD)
            ->resizeKeyboard()
            ->addRow(KeyboardButton::create(Emoji::leftArrow() .' '. __('bot.keyboard.back')))
            ->toArray();
    }
}