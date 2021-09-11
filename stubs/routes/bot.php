<?php

use App\Bot\Conversations\AboutPromoConversation;
use App\Bot\Conversations\AuthorizationConversation;
use App\Bot\Conversations\ChooseLanguageConversation;
use App\Bot\Conversations\MenuConversation;
use App\Bot\Conversations\ProfileConversation;
use App\Bot\Conversations\RegistrationConversation;
use App\Bot\Conversations\RulesConversation;
use App\Bot\Conversations\SendQuestionConversation;
use App\Bot\Conversations\SiteLinkConversation;
use App\Bot\Conversations\StartConversation;
use App\Bot\Conversations\WinnersChooseConversation;
use App\Bot\Conversations\WinnersDailyConversation;
use App\Bot\Conversations\WinnersWeeklyConversation;
use App\Bot\Middleware\CheckAuth;
use App\Bot\Middleware\TypeWait;
use BotMan\BotMan\BotMan;


$bot = botman_create();

$bot->hears('/start', function (BotMan $bot) { return $bot->startConversation(new StartConversation()); })->stopsConversation();


//$bot->hears('/authorization', function (Drivers $bot) { return $bot->startConversation(new AuthorizationConversation()); });
//$bot->hears('/registration', function (Drivers $bot) { return $bot->startConversation(new RegistrationConversation()); });


//$bot->hears('.*'.__('bot.menu.profile').'.*', function (Drivers $bot) { return $bot->startConversation(new ProfileConversation()); });
//$bot->hears('.*'.__('bot.menu.start_action').'.*', function (Drivers $bot) { return $bot->startConversation(new CouponConversation()); });
$bot->hears('.*'.__('bot.menu.products').'.*', function (BotMan $bot) { return $bot->startConversation(new ProductsConversation()); });
$bot->hears('.*'.__('bot.menu.send_question').'.*',  function (BotMan $bot) { return $bot->startConversation(new SendQuestionConversation()); });
$bot->hears('.*'.__('bot.menu.rules').'.*', function (BotMan $bot) { return $bot->startConversation(new RulesConversation()); });
$bot->hears('.*'.__('bot.menu.about_promo').'.*', function (BotMan $bot) { return $bot->startConversation(new AboutPromoConversation()); });
//$bot->hears('.*'.__('bot.menu.winners').'.*', function (Drivers $bot) { return $bot->startConversation(new WinnersConversation()); });
$bot->hears('.*'.__('bot.menu.language').'.*', function (BotMan $bot) { return $bot->startConversation(new ChooseLanguageConversation()); });
$bot->hears('.*'.__('bot.menu.site_link').'.*', function (BotMan $bot) { return $bot->startConversation(new SiteLinkConversation()); });


$bot->hears([__('bot.winners.daily'), '/winners/daily/{page}'], function (BotMan $bot, $page = 1) { return $bot->startConversation(new WinnersDailyConversation($page)); });
$bot->hears([__('bot.winners.weekly'), '/winners/weekly/{page}'], function (BotMan $bot, $page = 1) { return $bot->startConversation(new WinnersWeeklyConversation($page)); });


$bot->hears('.*'.__('bot.keyboard.back').'.*', function (BotMan $bot) { return $bot->startConversation(new MenuConversation()); } )->stopsConversation();
$bot->fallback( function (BotMan $bot) { return $bot->startConversation(new MenuConversation()); });


if (env('APP_ENV') == 'production') $bot->middleware->sending(new TypeWait());
$bot->listen();