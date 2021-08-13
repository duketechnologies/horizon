<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '';
});

Route::get('register_telegram_webhook', function () {
    \URL::forceScheme('https');

    $url_api_telegram_bot = 'https://api.telegram.org/bot' . config('botman.token') . '/setWebhook';
    $url_webhook = url('bot' . config('botman.token'));

    $response = Http::withHeaders([
        'Content-Type' => 'application/json'
    ])->post($url_api_telegram_bot, [
        'url' => $url_webhook
    ]);

    dd($response->body());
});