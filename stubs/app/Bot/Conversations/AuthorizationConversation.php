<?php

namespace App\Bot\Conversations;

use App\Bot\ApiService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use duke\helper\Rules\KZPhoneChecker;
use Spatie\Emoji\Emoji;

class AuthorizationConversation extends Conversation
{
    public function keyboard_phone()
    {
        return Keyboard::create()
            ->type(Keyboard::TYPE_KEYBOARD)
            ->oneTimeKeyboard(true)
            ->resizeKeyboard()
            ->addRow(KeyboardButton::create(Emoji::telephone() .' '. __('bot.keyboard.phone'))->requestContact(true))
            ->addRow(KeyboardButton::create(Emoji::leftArrow() .' '. __('bot.keyboard.back')))
            ->toArray();
    }

    public function keyboard_sms($again)
    {
        return Keyboard::create()
            ->type(Keyboard::TYPE_INLINE)
            ->addRow(KeyboardButton::create($again ? __('bot.keyboard.send_sms_again') : __('bot.keyboard.send_new_sms'))->callbackData('/repeat_sms'))
            ->toArray();
    }

    public function get_phone(){
        $this->ask(Emoji::telephone() .' '. __('bot.ask.phone'), function(Answer $answer) {
            $phone = $answer->getText() == '%%%_CONTACT_%%%' ?
                     $answer->getMessage()->getContact()->getPhoneNumber() :
                     remove_emoji($answer->getText());

            $validator = validate_field('phone', $phone, [new KZPhoneChecker()]);

            if($validator->fails()) {
                $this->say($validator->messages()->first());
                return $this->repeat();
            }

            $phone = kz_clear_phone($phone);
            user_storage()->set('phone', $phone);
            return $this->get_sms();
        }, $this->keyboard_phone());
    }

    public function get_sms($again = false){
        $this->say(__('bot.sms_sended', ['phone' => kz_format_phone(user_storage()->get('phone'))]), keyboard_back());
        $this->ask(Emoji::key() .' '. __('bot.ask.sms'), function(Answer $answer) {
            if (empty($answer->getValue())) {
                $sms = remove_emoji($answer->getText());
                $validator = validate_field('sms', $sms, ['min:4']);

                if($validator->fails()) {
                    $this->say($validator->messages()->first());
                    return $this->repeat();
                }

                $user_storage = user_storage()->set('sms', $sms);
                if(ApiService::userLogin([
                    'phone' => $user_storage->phone,
                    'sms' => $user_storage->sms,
                ])) {
                    return $this->send_text();
                } else {
                    $this->say(__('validation.custom.auth_failed'));
                    return $this->repeat();
                }
            } else if ($answer->getValue() == '/repeat_sms') {
                if(ApiService::userRestorePassword(['phone' => user_storage()->get('phone')])) return $this->get_sms(true);

                $this->say(__('validation.custom.phone_exist'));
                return $this->bot->startConversation(new ChooseAuthenticationConversation());
            }
        }, $this->keyboard_sms($again));
    }

    public function send_text(){
        return $this->bot->startConversation(new MenuConversation());
    }

    public function run()
    {
        $this->get_phone();
    }
}
