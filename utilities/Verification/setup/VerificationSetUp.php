<?php

namespace app\utilities\Verification\setup;


use app\models\GoogleTfa;
use app\models\TelegramTfa;
use app\models\User;
use app\utilities\Verification\VerificationInterface;
use app\utilities\Verification\VerificationTypes;

class VerificationSetUp
{
    /** @var User $user */
    public static $user;


    /** @var GoogleTfa $googleTFA */
    public static $googleTFA;

    /** @var TelegramTfa $telegramTFA */
    public static $telegramTFA;

    public static $verificationType = null;

    public static function init(){
        if (!self::$user) {
            self::$user = self::getUser();
        }

        if (!self::$googleTFA) {
            self::$googleTFA = self::getGoogleTFA();
        }

        if (!self::$telegramTFA) {
            self::$telegramTFA = self::getTelegramTFA();
        }

        if(self::$verificationType === null)
        {
            self::$verificationType = self::$user->tfa_type;
        }
    }

    public static function getVerificationStateInfo($type)
    {
        self::init();

        $enableEarlier = self::enableEarlier($type);


        if (self::$user->tfv_state === User::TFA_ON)
        {
            if(self::$user->tfa_type === $type){
                return "<div class=\"badge badge-pill badge-success\" style='background-color: #28a745;'> Настроено и используется </div>";
            }

            if(self::$user->tfa_type !== $type && $enableEarlier){
                return "<div class=\"badge badge-pill badge-secondary\" style='background-color: #17a2b8;'>Настроено и не используется</div>";
            }

            if(self::$user->tfa_type !== $type && !$enableEarlier){
                return "<div class=\"badge badge-pill badge-secondary\"> Не настроено </div>";
            }
        }

        if (self::$user->tfv_state === User::TFA_OFF)
        {
            if(self::$user->tfa_type === $type){
                return "<div class=\"badge badge-pill badge-secondary\" style='background-color: #17a2b8;'> Настроено и не используется </div>";
            }

            if(self::$user->tfa_type !== $type && $enableEarlier){
                return "<div class=\"badge badge-pill badge-secondary\" style='background-color: #17a2b8;'>Настроено и не используется</div>";
            }

            if(self::$user->tfa_type !== $type && !$enableEarlier){
                return "<div class=\"badge badge-pill badge-secondary\"> Не настроено </div>";
            }

        }

        return "<div class=\"badge badge-secondary\">Статус неизвестен</div>";
    }

    public static function getAuthSetUpPageHTML($type)
    {
        self::init();

        $enableEarlier = self::enableEarlier($type);

        /** @var VerificationInterface $verificationClass */
        $verificationClass = VerificationTypes::getClass($type);

        if(self::$user->tfv_state ===  User::TFA_ON)
        {
            if (self::$user->tfa_type === $type) {
                return $verificationClass::getDisableAuthHTML();
            }
            if(self::$user->tfa_type !== $type && $enableEarlier)
            {
                return $verificationClass::getEnableAuthHTML();
            }

            if(self::$user->tfa_type !== $type && !$enableEarlier)
            {
                return $verificationClass::getSetUpAuthHTML();
            }
        }

        if(self::$user->tfv_state === User::TFA_OFF)
        {
            if(self::$user->tfa_type === $type)
            {
                return $verificationClass::getEnableAuthHTML();
            }

            if(self::$user->tfa_type !== $type && $enableEarlier)
            {
                return $verificationClass::getEnableAuthHTML();
            }

            if(self::$user->tfa_type !== $type && !$enableEarlier)
            {
                return $verificationClass::getSetUpAuthHTML();
            }

            if(self::$user->tfa_type == null || self::$user->tfa_type == '')
            {
                return $verificationClass::getSetUpAuthHTML();
            }
        }

        return "Что-то пошло не так :(";
    }

    public static function getUser()
    {
        return User::findIdentity(\Yii::$app->user->id);
    }

    public static function getTelegramTFA()
    {
        return TelegramTfa::findOne(['user_id' => \Yii::$app->user->id]);
    }

    public static function getGoogleTFA()
    {
        return GoogleTfa::findOne(['user_id' => \Yii::$app->user->id]);
    }

    public static function enableEarlier($type){
        $enableEarlier = false;

        if($type === VerificationTypes::TFA_TYPE_TELEGRAM){
            if (self::$telegramTFA->chat_id != null || self::$telegramTFA->chat_id != '') {
                $enableEarlier = true;
            }
        }

        if($type === VerificationTypes::TFA_TYPE_GOOGLE_AUTH){
            if (self::$googleTFA->secret != null || self::$googleTFA->secret != '') {
                $enableEarlier = true;
            }
        }

        return $enableEarlier;
    }
}