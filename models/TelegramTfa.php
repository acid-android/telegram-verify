<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "telegram_tfa".
 *
 * @property int $id
 * @property int $chat_id
 * @property string $verification_code
 * @property int $user_id
 */
class TelegramTfa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_tfa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id', 'user_id'], 'integer'],
            [['verification_code'], 'string', 'max' => 255],
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
            'verification_code' => 'Verification Code',
            'user_id' => 'User ID',
        ];
    }
}
