<?php

namespace App\Bot\Conversations;

use Duke\Horizon\BotMan\Messages\Conversations\Conversation;
use Duke\Horizon\BotMan\Drivers\Telegram\Extensions\Keyboard;
use Duke\Horizon\BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use Spatie\Emoji\Emoji;

class WinnersChooseConversation extends Conversation
{
    public function keyboard()
    {
        return Keyboard::create(Keyboard::TYPE_KEYBOARD)
            ->resizeKeyboard()
            ->addRow(
                KeyboardButton::create(__('bot.winners.daily')),
                KeyboardButton::create(__('bot.winners.weekly')),
            )
            ->addRow(KeyboardButton::create(Emoji::leftArrow() .' '. __('bot.keyboard.back')))
            ->toArray();
    }
//    public function list_w_keyboard($page = 1)
//    {
//        $data = Winner::query()->paginate(30, ['*'], '', $page);
//        $text = '';
//
//        foreach ($data as $row) {
//            $text .= $row->created_at->format('d.m.Y') .' '. $row->phone .' '. $row->city . PHP_EOL;
//        }
//
//        return [
//            'text' => $text,
//            'keyboard' => (new InlineKeyboardPaginator)->build($data, '/winners/page/{}')
//        ];
//    }

//    public function send_text()
//    {
//        return $this->say(__('bot.winners.text'), $this->keyboard());
//        return $this->ask(__('bot.winners.text'), function (Answer $answer) {
//            $type = 'instant';
//            if($answer->getText() == __('bot.winners.daily')) $type = 'daily';
//            if($answer->getText() == __('bot.winners.weekly')) $type = 'weekly';
//
//            $data = $this->data($this->page);
//
//            if(!$data['text']) return $this->say('Победителей нет');
//
//            if(str_contains($this->bot->getMessage()->getText(), 'winners'))
//                return $this->bot->sendRequest('editMessageText', [
//                        'message_id' => $this->bot->getMessage()->getPayload()['message_id'],
//                        'text' => $data['text']
//                    ] + $data['keyboard']);
//
//            return $this->say($data['text'], $data['keyboard']);
//
//
//            return $this->bot->startConversation(new MenuConversation());
//        }, $this->keyboard());
//    }

    public function run() {
        return $this->say(__('bot.winners.text'), $this->keyboard());
//        $this->send_text();
    }
}
