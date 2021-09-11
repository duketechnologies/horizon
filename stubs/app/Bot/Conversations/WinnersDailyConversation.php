<?php

namespace App\Bot\Conversations;

use App\Bot\ApiService;
use App\Bot\InlineKeyboardPaginator;
use BotMan\BotMan\Messages\Conversations\Conversation;

class WinnersDailyConversation extends Conversation
{
    public $page;
    public $paginatedData;

    public function __construct($page)
    {
        $this->page = $page;
        $this->paginatedData = ApiService::winnersDaily(['page' => $this->page]);

        config(['botman.telegram.hideInlineKeyboard' => false]);
    }

    public function pagination()
    {
        return (new InlineKeyboardPaginator)->build($this->paginatedData, '/winners/daily/{}');
    }

    public function list()
    {
        $text = '';

        foreach ($this->paginatedData['data'] as $row) {
            $text .= $row['phone'] .' '. $row['date'] .' '. $row['prize'] . PHP_EOL;
        }

        return $text;
    }

    public function run()
    {
        if($this->paginatedData['total'] == 0) return $this->say(__('bot.winners.empty'));

        if(str_contains($this->bot->getMessage()->getText(), '/winners/daily/'))
            return $this->bot->sendRequest('editMessageText', [
                'message_id' => $this->bot->getMessage()->getPayload()['message_id'],
                'text' => $this->list()
            ] + $this->pagination());

        return $this->say($this->list(), $this->pagination());
    }
}
