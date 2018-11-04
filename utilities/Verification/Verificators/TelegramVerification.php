<?php

namespace app\utilities\Verification\Verificators;


use app\models\TelegramTfa;
use app\models\User;
use app\utilities\Verification\VerificationInterface;
use app\utilities\Verification\VerificationTypes;

class TelegramVerification implements VerificationInterface
{
    private $verification_code;
    private $hash;

    public function __construct($verification_code, $hash)
    {
        $this->verification_code = $verification_code;
        $this->hash = $hash;
    }

    public function verify(User $user)
    {
        $telegramTFA = TelegramTfa::findOne(['user_id' => $user->id]);
        if ($this->verification_code === $telegramTFA->verification_code) {
            $telegramTFA->verification_code = '';
            $user->hash = '';
            $user->save();
            $telegramTFA->save();
            return \Yii::$app->user->login($user);
        }
        return false;
    }

    public static function authorize(User $user)
    {
        $telegramTFA = TelegramTfa::findOne(['user_id' => $user->id]);
        $telegramTFA->verification_code = $user->generateVerificationCode();
        $user->hash = $user->generateHash();
        $telegramTFA->save();
        $user->sendVerificationCode();
        return $user->save();
    }

    public static function getEnableAuthHTML()
    {
        $url = \yii\helpers\Url::toRoute(['settings/verification-on', 'type' => VerificationTypes::TFA_TYPE_TELEGRAM]);

        return "
        <span>Двухфакторная аутентификаци выключена</span>
            <br>
            <br>
            <p>
                <a class=\"btn btn-success\" href=\"{$url}\">Включить</a>
            </p>
        ";
    }

    public static function getDisableAuthHTML()
    {
        $url = \yii\helpers\Url::to('verification-off');
        return "
        <span>Двухфакторная аутентификаци включена</span>
            <br>
            <br>
            <p>
                <a class=\"btn btn-success\" href=\"{$url}\">Выключить</a>
            </p>
        ";
    }

    public static function getSetUpAuthHTML()
    {
        $url = \app\utilities\BotApi::getBotURL();
        return "
        <span>Для начала, подпишись на нашего бота в Telegram:)</span>
            <br>
            <br>
            <p>
                <a id=\"bot-subscribe-button\" class=\"btn btn-primary\" href=\"{$url}\" target=\"_blank\">БОТ</a>
            </p>

            <br>
            <br>
            <div id=\"confirm-verify\" style=\"display: none;\">

                <span>А теперь нажми на кнопку Готово, если успешно подписался</span>
                <br>
                <br>
                <br>

                <div class=\"btn btn-success\" id=\"bot-ok\">Готово</div>
            </div>
        ";
    }


}