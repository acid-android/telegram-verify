<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Заполните поля для регистрации:</p>
    <p style="color: #a5a3a3; user-select: none;">(все поля обязательны для заполнения)</p>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'first_name')->textInput(['autofocus' => true])->label('Имя') ?>
            <?= $form->field($model, 'last_name')->textInput()->label('Фамилия') ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'telegram')->textInput()->label('Telegram') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
            <div class="form-group">
                <?= Html::submitButton('Зарегестрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button', 'id' => 'signup-submit-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>