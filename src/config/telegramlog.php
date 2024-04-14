<?php


return [

    'channels' => [

        'info' => [
            'bot_token'     => env('TELEGRAM_BOT_TOKEN'),
            'chat_group_id' => env('TELEGRAM_LOG_INFO_CHAT_GROUP_ID')
        ],

        'error'  => [
            'bot_token'     => env('TELEGRAM_BOT_TOKEN'),
            'chat_group_id' => env('TELEGRAM_LOG_ERROR_CHAT_GROUP_ID')
        ],
    ],

];
