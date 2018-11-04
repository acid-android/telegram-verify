<?php

namespace app\controllers;


use app\models\LoginForm;
use app\models\User;
use app\models\VerifyForm;
use yii\web\Controller;

class LoginController extends Controller
{
    public function actionIndex()
    {
        $model = new LoginForm();

        if ($model->load(\Yii::$app->request->post()) && $model->authorize()) {
            if($model->getUser()->tfv_state == User::TFA_ON) {
                return $this->redirect([
                    'login/verify',
                    'hash' => $model->getUserHash()
                ]);
            }
            return $this->goHome();
        }

        return $this->render('index', [
            'model' => $model
        ]);

    }

    public function actionVerify($hash)
    {
        $model = new VerifyForm();
        $model->hash = $hash;
        if (\Yii::$app->request->isPost){
            $model->verification_code = \Yii::$app->request->post('VerifyForm')['verification_code'];
            if($model->verify()){
                return $this->goHome();
            }
        }


        return $this->render('verify', [
           'model' => $model,
            'message' => $model->getMessage($hash)
        ]);

    }

}