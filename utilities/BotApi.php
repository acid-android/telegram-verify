<?php

namespace app\utilities;

use app\models\TelegramChats;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class BotApi
{
    protected $telegram;
    protected $updates;

    public $API_KEY = '630068467:AAG-4klz_z2v9Ajakd_XEPfyh7nJfLtixmU';
    public $PREFIX = '@';
    public static $BOT_NAME = 'hillel_demo_verify_bot';
    public $COMMANDS_FOLDER = 'app/commands';

    public function __construct()
    {
        try {
            $this->telegram = new Telegram($this->API_KEY, $this->PREFIX . static::$BOT_NAME);
            $this->telegram->useGetUpdatesWithoutDatabase();
            $this->getUpdates();
            $this->parseUpdates();

        } catch (TelegramException $e) {
            echo $e->getMessage();
        }
    }

    protected function getUpdates()
    {
        $server_response = $this->telegram->handleGetUpdates();
        if ($server_response->isOk()) {
            $this->updates = $server_response->getResult();
        } else {
            echo date('Y-m-d H:i:s', time()) . ' - Failed to fetch updates' . PHP_EOL;
            echo $server_response->printError();
        }

        return $this->updates;
    }

    protected function parseUpdates()
    {
        foreach ($this->updates as $item) {
            $chat = $item->getMessage()->getChat();
            $savedChat = TelegramChats::findOne(['chat_id' => $chat->id]);
            if (!$savedChat) {
                $telegramChat = new TelegramChats();
                $telegramChat->chat_id = $chat->id;
                $telegramChat->username = $chat->username;
                $telegramChat->save();
                return true;
            }
        }

        return false;
    }

    public function findChatByUsername($username)
    {
        return TelegramChats::findOne(['username' => $username]);

    }

    public static function getBotURL()
    {
        return 'https://t.me/' . self::$BOT_NAME . '?start=OK';
    }

    public function sendMessage($chat_id, $message)
    {
        try {
            $result = Request::sendMessage([
                'chat_id' => $chat_id,
                'text' => $message,
            ]);
        } catch (TelegramException $e) {
            $e->getMessage();
        }
    }

}