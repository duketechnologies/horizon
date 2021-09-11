<?php

namespace App\Bot;

use BotMan\Drivers\TelegramExtensions\Keyboard;
use BotMan\Drivers\TelegramExtensions\KeyboardButton;

class InlineKeyboardPaginator
{
    public $keyboard_array = [];

    public $first_page_label = '« {}';
    public $previous_page_label = '‹ {}';
    public $next_page_label = '{} ›';
    public $last_page_label = '{} »';
    public $current_page_label = '-{}-';

    public function build($paginator, $pageName = '/page/{}')
    {
        if ($paginator['last_page'] == 1) return $this->keyboard_array;

        else if ($paginator['last_page'] <= 5) {
            foreach (range(1, $paginator['last_page'] + 1) as $page)
                $this->keyboard_array[$page] = $page;
        }

        else $this->keyboard_array = $this->build_for_multi_pages($paginator);

        $this->keyboard_array[$paginator['current_page']] = strtr($this->current_page_label, ['{}' => $paginator['current_page']]);


        return $this->keyboard_to_array($this->keyboard_array, $pageName);
    }

    public function build_for_multi_pages($paginator)
    {
        if($paginator['current_page'] <= 3)
            return $this->build_start_keyboard($paginator);

        else if($paginator['current_page'] > $paginator['last_page'] - 3)
            return $this->build_finish_keyboard($paginator);

        else
            return $this->build_middle_keyboard($paginator);
    }

    public function build_start_keyboard($paginator)
    {
        foreach (range(1, 4) as $page)
            $this->keyboard_array[$page] = $page;

        $this->keyboard_array[4] = strtr($this->next_page_label,["{}" => 4]);
        $this->keyboard_array[$paginator['last_page']] = strtr($this->last_page_label, '{}', $paginator['last_page']);

        return $this->keyboard_array;
    }

    public function build_finish_keyboard($paginator)
    {
        $this->keyboard_array[1] = strtr($this->first_page_label, ['{}' => 1]);
        $this->keyboard_array[$paginator['last_page'] - 3] = strtr($this->previous_page_label, ['{}' => $paginator['last_page'] - 3]);

        foreach (range($paginator['last_page'] - 2, $paginator['last_page']) as $page)
            $this->keyboard_array[$page] = $page;

        return $this->keyboard_array;
    }

    public function build_middle_keyboard($paginator)
    {
        $this->keyboard_array[1] = strtr($this->first_page_label, ['{}' => 1]);
        $this->keyboard_array[$paginator['current_page'] - 1] = strtr($this->previous_page_label, ['{}' => $paginator['current_page'] - 1]);
        $this->keyboard_array[$paginator['current_page']] = $paginator['current_page'];
        $this->keyboard_array[$paginator['current_page'] + 1] = strtr($this->next_page_label, ['{}' => $paginator['current_page'] + 1]);
        $this->keyboard_array[$paginator['last_page']] = strtr($this->last_page_label, ['{}' => $paginator['last_page']]);

        return $this->keyboard_array;
    }

    public function keyboard_to_array($keyboard_array, $pageName)
    {
        foreach ($keyboard_array as $key => $label) $buttons[] = KeyboardButton::create($label)->callbackData(strtr($pageName, ['{}' => $key]));
        return Keyboard::create()->type(Keyboard::TYPE_INLINE)->addRow(...$buttons)->toArray();
    }
}