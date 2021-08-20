<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '';
});

Route::get('register_telegram_webhook', function () {
    \URL::forceScheme('https');

    $token = config('botman.telegram.token');
    $url_api_telegram_bot = 'https://api.telegram.org/bot' . $token . '/setWebhook';
    $url_webhook = url('bot' . $token);

    $response = Http::post($url_api_telegram_bot, [ 'url' => $url_webhook ]);

    dd($response->json());
});