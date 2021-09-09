<?php

use App\Models\UserStorage;
use Duke\Horizon\BotManTelegram\Extensions\Keyboard;
use Duke\Horizon\BotManTelegram\Extensions\KeyboardButton;
use Duke\Horizon\BotManTelegram\TelegramDriver;
use Duke\Horizon\Rules\TelegramTextChecker;
use Duke\Horizon\BotMan\BotManFactory;
use Duke\Horizon\BotMan\Cache\LaravelCache;
use Duke\Horizon\BotMan\Drivers\DriverManager;
use Spatie\Emoji\Emoji;

if (! function_exists('botman_create')) { // Create a new BotMan instance.
    function botman_create() {
        $config = config('botman');
        DriverManager::loadDriver(TelegramDriver::class);
        return BotManFactory::create($config, new LaravelCache());
    }
}

if (! function_exists('chat_id')) { // Get chat id data from request
    function chat_id() {
        return request()->input('message.chat.id') ?? request()->input('callback_query.message.chat.id');
    }
}

if (! function_exists('rules_url')) {
    function rules_url() {
        return env('SITE_URL').'docs/rules_'.app()->getLocale().'.pdf?t='.time();
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

if (! function_exists('user_storage')) {
    function user_storage()
    {
        return UserStorage::where('telegram_id', chat_id())->first();
    }
}