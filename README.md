## LARAVEL logger to telegram chat

Desctiption: sending error or info messages to target telegram chat from laravel application.  Using two channels (info/error). Possibility use different bots for sending messeges or using only one bot and one chat. Git link https://github.com/doker42/telegramlog

###   instalation 
    - composer require doker42/laravel-telegram-log

###  add config file telegramlog.php to config directory


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


###  add data to .env,  telegramBotId, telegramChatId

    TELEGRAM_BOT_TOKEN=<token>
    TELEGRAM_LOG_INFO_CHAT_GROUP_ID=<chat_group_id>
    TELEGRAM_LOG_ERROR_CHAT_GROUP_ID=<chat_group_id>

### basic usage 

    use Doker42\Telegramlog\TelegramLogger;

    $message = [
        'text' => 'test text',
        'message' => 'test message',
        ...
    ];

    /** INFO log chat */
    TelegramLogger::dispatch($message, TelegramLogger::TYPE_INFO);
    /** ERROR log chat */
    TelegramLogger::dispatch($message, TelegramLogger::TYPE_ERROR);
