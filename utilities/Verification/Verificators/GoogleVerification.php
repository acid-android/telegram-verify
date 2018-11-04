<?php

namespace app\utilities\Verification\Verificators;


use app\models\GoogleTfa;
use app\models\User;
use app\utilities\Verification\setup\VerificationSetUp;
use app\utilities\Verification\VerificationInterface;
use app\utilities\Verification\VerificationTypes;
use Google\Authenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

class GoogleVerification implements VerificationInterface
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
        $googleTFA = GoogleTfa::findOne(['user_id' => $user->id]);
        $g = new GoogleAuthenticator();
        var_dump($g->checkCode($googleTFA->secret, $this->verification_code));
        if($g->checkCode($googleTFA->secret, $this->verification_code)){
            $user->hash = '';
            $user->save();
            return \Yii::$app->user->login($user);
        }
        return false;
    }

    public static function authorize(User $user)
    {
        $user->hash = $user->generateHash();

        return $user->save();
    }

//    public static function getGoogleQrHTML($code)
//    {
//        $url = \Yii::$app->request->baseUrl . '/api/submit-tfa';
//
//        return "
//            <p>Отсканируйте QR код в Google Authenticator для включения двухфакторной аутентификации</p>
//            <img src='{$code}'/>
//
//            <p>А теперь нажмите далее</p>
//            <br>
//            <br>
//            <p>
//                <a class=\"btn btn-success\" href=\"{$url}\">Далее</a>
//            </p>";
//    }
//
//    public static function getVerificationEnableHTML()
//    {
//        $url = \yii\helpers\Url::toRoute(['settings/verification-on', 'type' => VerificationTypes::TFA_TYPE_GOOGLE_AUTH]);
//
//        return "
//        <span>Двухфакторная аутентификаци выключена</span>
//            <br>
//            <br>
//            <p>
//                <a class=\"btn btn-success\" href=\"{$url}\">Включить</a>
//            </p>
//        ";
//    }
//
//    public static function getVerificationShutdownHTML()
//    {
//        $url = \yii\helpers\Url::to('verification-off');
//        return "
//        <span>Двухфакторная аутентификаци включена</span>
//            <br>
//            <br>
//            <p>
//                <a class=\"btn btn-success\" href=\"{$url}\">Выключить</a>
//            </p>
//        ";
//    }

    public static function getEnableAuthHTML()
    {
        $url = \yii\helpers\Url::toRoute(['settings/verification-on', 'type' => VerificationTypes::TFA_TYPE_GOOGLE_AUTH]);

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
        $url = \Yii::$app->request->baseUrl . '/api/submit-tfa';

        $code = null;

        $user = VerificationSetUp::$user;

        $user->tfa_type = VerificationTypes::TFA_TYPE_GOOGLE_AUTH;
        $user->tfv_state = User::TFA_ON;

        $g = new GoogleAuthenticator();
        $googleTFA = VerificationSetUp::$googleTFA;

        if(!$googleTFA->secret) {
            $googleTFA->secret = $g->generateSecret();
        }
        $code = GoogleQrUrl::generate($user->email, $googleTFA->secret, 'TelegramVerifyDemo');

        $googleTFA->save();
        $user->save();

        return "
            <p>Отсканируйте QR код в Google Authenticator для включения двухфакторной аутентификации</p>
            <img src='{$code}'/>
            
            <p>А теперь нажмите далее</p>
            <br>
            <br>
            <p>
                <a class=\"btn btn-success\" href=\"{$url}\">Далее</a>
            </p>";
    }


}