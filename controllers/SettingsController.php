<?php

namespace app\controllers;

use app\models\User;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;

class SettingsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');

    }

    public function actionTfa()
    {
        $user = User::findIdentity(\Yii::$app->user->id);
        $state = $user->tfv_state;
        return $this->render('verify', [
            'verificationState' => $state,
            'telegramTFAWasTurnedOnEarlier' => $user->telegramTFAWasTurnedOnEarlier(),
            'googleTFAWasTurnedOnEarlier' => $user->googleTFAWasTurnedOnEarlier(),
            'verificationType' => $user->tfa_type
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

    public function actionVerificationOff()
    {
        $user = User::findIdentity(\Yii::$app->user->id);
        $user->tfv_state = User::TFA_OFF;
        $user->save();

        return $this->redirect(Url::to(\Yii::$app->request->baseUrl . '/settings/tfa'));
    }

    public function actionVerificationOn($type)
    {
        $user = User::findIdentity(\Yii::$app->user->id);
        $user->tfv_state = User::TFA_ON;
        $user->tfa_type = $type;
        $user->save();

        return $this->redirect(Url::to(\Yii::$app->request->baseUrl . '/settings/tfa'));
    }
}