<?php


namespace Doker42\Telegramlog;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Api;

class TelegramLogger implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $text;

    public string $type;

    public string $botToken;

    public string $chatGroupId;

    public const TYPE_INFO = 'info';

    public const TYPE_ERROR  = 'error';


    public function __construct(
        array $text,
        string $type,
    )
    {
        $this->text = $text;
        $this->type = $type;
    }


    /**
     * @return void
     */
    public function handle(): void
    {
        self::telegram_send_message();
    }


    /**
     * @return void
     */
    private function telegram_send_message(): void
    {
        /**  default  */
        $this->botToken    = config('telegramlog.channels.info.bot_token');
        $this->chatGroupId = config('telegramlog.channels.info.chat_group_id');

        /**  define  channel  */
        if ($this->type === self::TYPE_INFO) {

            $this->botToken    = config('telegramlog.channels.info.bot_token');
            $this->chatGroupId = config('telegramlog.channels.info.chat_group_id');

        } elseif ($this->type == self::TYPE_ERROR) {

            $this->botToken    = config('telegramlog.channels.error.bot_token');
            $this->chatGroupId = config('telegramlog.channels.error.chat_group_id');
        }

        $this->send();
    }


    /**
     * @return void
     */
    private function send(): void
    {
        $message = '';
        $message = $this->getMessagino($this->text, $message);

        try {
            $telegram = new Api($this->botToken);
            $telegram->sendMessage([
                'chat_id' => $this->chatGroupId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

        }
        catch (TelegramSDKException|\Exception $e) {

            Log::error('Telegram failed: ' . $e->getMessage());

        }
    }



    /**
     *  create message from data array recursively
     *
     * @param $text
     * @param $message
     * @return mixed|string
     */
    private function getMessagino($text, $message)
    {

        foreach ($text as $key => $val) {

            if (is_array($val)) {

                if (is_string($key)) {
                    $message .= $key . "\n";
                }

                $message = $this->getMessagino($val, $message);

            } else {

                if (is_numeric($key)) {

                    $message .= $val . " \n";

                } elseif (is_string($key)) {

                    $message .= "\n<b>$key:</b> " . $val . " \n";
                }
            }
        }

        return $message;
    }

}
