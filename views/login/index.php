<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Вход</p>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'form-login']); ?>
            <?= $form->field($model, 'email')->textInput()->label('Email') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button', 'id' => 'login-submit-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>