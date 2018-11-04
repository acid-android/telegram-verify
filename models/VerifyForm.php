<?php

namespace app\models;

use app\utilities\Verification\Verification;
use app\utilities\Verification\VerificationTypes;
use yii\base\Model;

class VerifyForm extends Model
{
    public $verification_code;
    public $hash;
    public $user;

    public static $verifyMessages = [
       VerificationTypes::TFA_TYPE_TELEGRAM => 'Код подтверждения отправлен Вам в Telegram',
       VerificationTypes::TFA_TYPE_GOOGLE_AUTH => 'Введите код подтверждения из Google Authenticator'
    ];

    public function verify()
    {
        $verification = null;
        $this->user = User::findIdentityByAccessToken($this->hash);
        try {
            $verification = new Verification($this->user->tfa_type, $this->verification_code, $this->hash);
        } catch (\Exception $e){
            echo $e->getMessage();
        }
        return $verification->verify();
    }

    public static function getMessage($hash){
        $user = User::findIdentityByAccessToken($hash);
        return self::$verifyMessages[$user->tfa_type];
    }

}