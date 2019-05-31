<?php

require_once 'TrelloDispatcher.php';
require_once 'TrelloApiService.php';

function process_form($form)
{
    // Вызовет die(), если будут какие-нибудь ошибки.
    check_required_fields($form);

    // Вызовет die(), если будут проблемы при отправке.
    email_form_submission($form);

    // Создание карточки в Trello.
    sendToTrello($form);
}

function sendToTrello($form)
{
    try {
        // Устанавливаем требуемый часовой пояс.
        date_default_timezone_set('Asia/Yekaterinburg');
        $trelloCardName = 'Заявка от ' . date('Y.m.d H:i');
        $trelloCardDescription = <<<HEREDOC
Наименование: {$form['item_name']}
Артикул: {$form['item_article']}
Количество: {$form['item_qty']}
Общая стоимость: {$form['item_sum']}
ФИО клиента: {$form['user_name']}
Телефон: {$form['user_phone']}
Адрес доставки: {$form['delivery_address']}
HEREDOC;
        // Указываем Token, ключ API и идентификатор списка.
        $trelloToken = '5f518a17a0181932830ce5a84c8ee3eee32830a5bfe71ec3b8e67ef2e70903ec';
        $trelloApiKey = 'f353503690b2fbbe5f801b5b03690a44';
        $trelloListId = '5c99d2bbfac3c99d2b288100';
        $trelloDispatcher = new TrelloDispatcher($trelloApiKey, $trelloToken, new TrelloApiService());
        $trelloDispatcher->createCard($trelloListId, $trelloCardName, $trelloCardDescription);
    } catch (Exception $e) {
        // ... обработка ошибок
    }
}

function check_required_fields($form)
{
    // ...
}

function email_form_submission($form)
{
    // ...
}

$form = [
    'item_name' => 'Название товара',
    'item_article' => 123456,
    'item_qty' => 10,
    'item_sum' => 1350.0,
    'user_name' => 'Иванов Иван Иванович',
    'user_phone' => '+7(999)999-99-99',
    'delivery_address' => 'Свердловская область, г. Екатеринбург, ул. Черняховского, д.86, корп.8',
];

process_form($form);
