<?php

namespace app\utilities\Verification;


use app\models\User;

interface VerificationInterface
{
    public function verify(User $user);

    public static function authorize(User $user);

    public static function getEnableAuthHTML();

    public static function getDisableAuthHTML();

    public static function getSetUpAuthHTML();

}