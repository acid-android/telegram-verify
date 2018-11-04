<?php

namespace app\controllers;


use app\models\SignUpForm;
use yii\web\Controller;

class SignUpController extends Controller
{
    public function actionIndex()
    {
        $model = new SignUpForm();

        if ($model->load(\Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect('login');
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}