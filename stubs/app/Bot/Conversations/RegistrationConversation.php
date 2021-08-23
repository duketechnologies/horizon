<?php

namespace App\Bot\Conversations;

use App\Bot\ApiService;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use duke\helper\Rules\KZPhoneChecker;
use Spatie\Emoji\Emoji;

class RegistrationConversation extends Conversation
{
    public function keyboard_rules()
    {
        return Keyboard::create()
            ->type(Keyboard::TYPE_INLINE)
            ->addRow(KeyboardButton::create(__('bot.keyboard.rules'))->callbackData('accept'))
            ->toArray();
    }

    public function keyboard_phone()
    {
        return Keyboard::create()
            ->type(Keyboard::TYPE_KEYBOARD)
            ->resizeKeyboard()
            ->addRow(KeyboardButton::create(Emoji::telephone() .' '. __('bot.keyboard.phone'))->requestContact(true))
            ->addRow(KeyboardButton::create(Emoji::leftArrow() .' '. __('bot.keyboard.back')))
            ->toArray();
    }

    public function keyboard_sms()
    {
        return Keyboard::create()
            ->type(Keyboard::TYPE_INLINE)
            ->addRow(KeyboardButton::create(__('bot.keyboard.send_sms_again'))->callbackData('sms_send_again'))
            ->toArray();
    }

    public function send_rules(){
        $attachment = new File(rules_url());
        $message = OutgoingMessage::create()->withAttachment($attachment);

        $this->say($message, keyboard_back());
        $this->ask(Emoji::pageFacingUp() .' '. __('bot.ask.rules'), function (Answer $answer) {
            if ($answer->getValue() && $answer->getValue() == 'accept') {
                $this->get_name();
            } else {
                return $this->repeat();
            }
        }, $this->keyboard_rules());
    }

    public function get_name(){
        $this->ask(Emoji::bustInSilhouette() .' '. __('bot.ask.name'), function(Answer $answer) {
            $name = remove_emoji($answer->getText());
            $validator = validate_field('name', $name, ['min:2']);
            if($name == 'accept') return $this->repeat();

            if($validator->fails()) {
                $this->say($validator->messages()->first());
                return $this->repeat();
            }

            user_storage()->set('name', $name);
            $this->get_phone();
        });
    }

    public function get_phone(){
        $this->ask(Emoji::telephone() .' '. __('bot.ask.phone'), function(Answer $answer) {
            $phone = $answer->getText() == '%%%_CONTACT_%%%' ?
                    $answer->getMessage()->getContact()->getPhoneNumber() :
                    remove_emoji($answer->getText());

            $validator = validate_field('phone', $phone, [new KZPhoneChecker]);

            if($validator->fails()) {
                $this->say($validator->messages()->first());
                return $this->repeat();
            }

           user_storage()->set('phone', kz_clear_phone($phone));
            if (ApiService::userRegister()) {
                return $this->get_sms();
            }
            else {
                $this->say(__('validation.custom.phone_unique'));
                return $this->bot->startConversation(new ChooseAuthenticationConversation());
            }
        }, $this->keyboard_phone());
    }

    public function get_sms(){
        $this->say(__('bot.sms_sended', ['phone' => kz_format_phone(user_storage()->get('phone'))]), keyboard_back());
        $this->ask(Emoji::key() .' '. __('bot.ask.sms'), function(Answer $answer) {
            if (empty($answer->getValue())) {
                $sms = remove_emoji($answer->getText());
                $validator = validate_field('sms', $sms, ['min:4']);

                if($validator->fails()) {
                    $this->say($validator->messages()->first());
                    return $this->repeat();
                }

                user_storage()->set('sms', $sms);
                if(ApiService::userLogin()) {
                    return $this->send_text();
                } else {
                    $this->say(__('validation.custom.auth_failed'));
                    return $this->repeat();
                }
            } else if ($answer->getValue() == 'sms_send_again') {
                ApiService::userRestorePassword();
                return $this->repeat();
            }
        }, $this->keyboard_sms());
    }

    public function send_text(){
        return $this->bot->startConversation(new MenuConversation());
    }

    public function run()
    {
        $this->send_rules();
    }
}
