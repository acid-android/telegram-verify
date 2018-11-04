<?php
namespace app\controllers;


use app\models\User;
use yii\web\Controller;

class TestController extends Controller {
    public function actionIndex(){
        $users = User::find()->asArray()->all();

        var_dump($users);
    }
}