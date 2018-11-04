<?php

namespace app\controllers;


use app\models\User;
use app\utilities\Verification\setup\VerificationSetUp;
use app\utilities\Verification\VerificationTypes;
use yii\helpers\Json;
use yii\web\Controller;

class ApiController extends Controller
{
    public function actionSetUpTelegramTfa()
    {
        $html = VerificationSetUp::getAuthSetUpPageHTML(VerificationTypes::TFA_TYPE_TELEGRAM);
        return Json::encode([
            'data' => $this->renderPartial('set-telegram-tfa', [
                'html' => $html
            ])
        ]);
    }

    public function actionSetUpGoogleTfa()
    {
        $html = VerificationSetUp::getAuthSetUpPageHTML(VerificationTypes::TFA_TYPE_GOOGLE_AUTH);
        return Json::encode([
            'data' => $this->renderPartial('set-google-tfa', [
                'html' => $html
            ])
        ]);

    }

    public function actionCheckBotSubscribe()
    {
        $user = User::findIdentity(\Yii::$app->user->id);
        if ($user->getTelegramChatId()) {
            \Yii::$app->user->logout();
            $url = \Yii::$app->homeUrl . '/login';
            return Json::encode([
                'data' => $this->renderPartial('verification_ok', [
                    'url' => $url
                ])
            ]);
        }
        return Json::encode([
            'data' => $this->renderFile('verification_not_ok')
        ]);
    }

    public function actionSubmitTfa()
    {
        \Yii::$app->user->logout();
        $this->redirect(\Yii::$app->request->baseUrl.'/login');
    }
}