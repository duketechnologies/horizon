<?php

return [
    'menu' => [
        'profile' => 'Личный кабинет',
        'start_action' => 'Зарегистрировать чек', 'products' => 'Список продуктов',
        'send_question' => 'Обратная связь', 'rules' => 'Правила акции',
        'about_promo' => 'Об акции', 'winners' => 'Победители',
        'language' => 'Смена языка',
        'site_link' => 'Перейти на сайт',
    ],




    'start' => [
        'text' => 'Здравствуйте! Я бот',
        'restricted' => 'Прости, политика нашей компании не позволяет открывать сайт пользователям младше 14 лет. Попроси кого-то из взрослых выиграть тебе приз!',
    ],
    'authorization' => [
        'success' => 'Осталось купить',
    ],
    'profile' => [
        'user_data' => 'Имя: :name'.PHP_EOL.'Телефон: :phone',
    ],
    'check' => [
        'text' => 'Зарегистрируй фотографию чека',
        'success' => 'Отлично! Чек загружен',
    ],
    'about_promo_text' => 'ПРАВИЛА УЧАСТИЯ:'.PHP_EOL.'',






    'ask' => [
        'rules' => 'Правила акции можно прочитать в этом файле.',
        'name' => 'Введи свое имя.',
        'city' => 'Введи свой город.',
        'phone' => 'Введи свой номер телефона.',
        'sms' => 'Введи код из SMS.',
        'age' => 'Тебе исполнилось 14 лет?'
    ],
    'keyboard' => [
        'authorization' => 'Вход',
        'registration' => 'Регистрация',
        'rules' => 'Принять правила акции',
        'phone' => 'Показать мой номер телефона',
        'send_sms_again' => 'Отправить ещё раз',
        'send_new_sms' => 'Отправить новый код',
        'back' => 'Назад',
        'send' => 'Отправить',
        'edit' => 'Изменить',
        'show_delivery' => 'Форма доставки',
        'store_delivery' => 'Заполнить форму доставки',
        'promocode' => 'Копировать промокод',
        'yes' => 'Да',
        'no' => 'Нет',
    ],
    'choose_language' => [
        'text' => 'Выбери язык бота / Тілдесу тілін таңда:'
    ],
    'choose_auth' => [
        'alert' => 'Чтобы продолжить использовать бота тебе нужно зайти в аккаунт.',
        'text' => 'Выберите способ авторизации:',
    ],
    'sms_sended' => 'Сообщение с кодом для подтверждения отправлен на номер :phone',
    'menu_text' => 'Используйте меню для навигации по чат боту!',
    'send_question' => [
        'text' => 'Есть вопрос?'.PHP_EOL.'Найди его в списке часто задаваемых на сайте '.env('SITE_URL').' или напиши нам.',
        'confirm' => 'Ваш вопрос:'.PHP_EOL.':question',
        'success' => 'Спасибо за обращение!'.PHP_EOL.'В скором времени мы ответим на твой вопрос.',
    ],
    'site_link_text' => 'Нажмите на кнопку, чтобы перейти на сайт',
    'winners' => [
        'instant' => 'Моментальные',
        'weekly' => 'Еженедельные',
        'main' => 'Главные',
        'empty' => 'Победителей пока нет.'
    ],
];