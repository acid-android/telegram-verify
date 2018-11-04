<?php

namespace app\utilities\Verification;


use app\models\User;



class Verification
{
    /** @var VerificationInterface $verificationClass */
    protected $verificationClass;

    public static $verificationClassMap = [
        VerificationTypes::TFA_TYPE_TELEGRAM => "app\utilities\Verification\Verificators\TelegramVerification",
        VerificationTypes::TFA_TYPE_GOOGLE_AUTH => "app\utilities\Verification\Verificators\GoogleVerification",
    ];

    protected $user;

    public function __construct($verificationMethod, $verification_code, $hash)
    {
        $this->user = User::findIdentityByAccessToken($hash);

        if(!in_array($verificationMethod, [VerificationTypes::TFA_TYPE_TELEGRAM, VerificationTypes::TFA_TYPE_GOOGLE_AUTH])){
            throw new \Exception('Undefined verification type');
        }

        $class = static::$verificationClassMap[$verificationMethod];

        $this->verificationClass = new $class($verification_code, $hash);
    }

    public function verify(){
        return $this->verificationClass->verify($this->user);
    }

    public static function authorize(User $user){
        /** @var VerificationInterface $class */
        $class = static::$verificationClassMap[$user->tfa_type];
        return $class::authorize($user);
    }

}