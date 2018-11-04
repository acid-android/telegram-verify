<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "telegram_chats".
 *
 * @property int $id
 * @property int $chat_id
 * @property string $username
 */
class TelegramChats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_chats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id', 'username'], 'required'],
            [['chat_id'], 'integer'],
            [['username'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'username' => 'Username',
        ];
    }
}
