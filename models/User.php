<?php

namespace app\models;

use app\utilities\BotApi;
use app\utilities\Verification\VerificationTypes;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $telegram
 * @property string $password
 * @property string $hash
 * @property integer $tfv_state
 * @property integer $tfa_type
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const TFA_OFF = 0;
    const TFA_ON = 1;



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'first_name', 'last_name', 'telegram', 'password'], 'required'],
            [['email', 'first_name', 'last_name', 'telegram', 'password', 'hash'], 'string'],
            [[ 'tfa_type', 'tfv_state'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'telegram' => 'Telegram',
            'password' => 'Password',
            'hash' => 'Hash',
            'tfv_state' => 'TFW State',
            'tfa_type' => 'TFA Type',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);

    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->verification_code;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->verification_code === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password == password_verify($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function generateVerificationCode()
    {
        return Yii::$app->security->generateRandomString(6);
    }

    public function generateHash()
    {
        return Yii::$app->security->generateRandomString(32);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['hash' => $token]);
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function getTelegramChatId()
    {
        $bot = new BotApi();
        $chat = $bot->findChatByUsername($this->telegram);
        if ($chat) {
            $telegramTFA = TelegramTfa::findOne(['user_id' => $this->id]);
            $telegramTFA->chat_id = $chat->chat_id;
            $telegramTFA->save();
            $this->tfv_state = self::TFA_ON;
            $this->tfa_type = VerificationTypes::TFA_TYPE_TELEGRAM;
            $this->save();
            $message = 'Ура, вы подключили двухфакторную аутентификацию!!! :)';

            $bot->sendMessage($telegramTFA->chat_id, $message);

            return true;
        }

        return false;
    }

    public function sendVerificationCode()
    {
        $bot = new BotApi();
        $telegramTFA = TelegramTfa::findOne(['user_id' => $this->id]);

        $message = 'Ваш код авторизации: ' . $telegramTFA->verification_code;

        $bot->sendMessage($telegramTFA->chat_id, $message);
    }

    public function telegramTFAWasTurnedOnEarlier()
    {
        $telegramTFA = TelegramTfa::findOne(['user_id' => $this->id]);
        return isset($telegramTFA->chat_id);
    }

    public function googleTFAWasTurnedOnEarlier()
    {
        $googleTFA = GoogleTfa::findOne(['user_id' => $this->id]);
        return isset($googleTFA->secret);
    }

}
