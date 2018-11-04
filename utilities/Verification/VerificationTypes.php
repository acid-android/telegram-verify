<?php

namespace app\utilities\Verification;


class VerificationTypes
{
    const TFA_TYPE_TELEGRAM = 0;
    const TFA_TYPE_GOOGLE_AUTH = 1;

    public static $verificationClassMap =[
        self::TFA_TYPE_TELEGRAM => 'app\utilities\Verification\Verificators\TelegramVerification',
        self::TFA_TYPE_GOOGLE_AUTH => 'app\utilities\Verification\Verificators\GoogleVerification'
    ];


    public static function getClass($type)
    {
        return self::$verificationClassMap[$type];
    }

}