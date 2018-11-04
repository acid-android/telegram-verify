<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Потверждение входа';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Подтвреждение входа</p>
    <p><?= $message ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-verify']); ?>
            <?= $form->field($model, 'hash')->hiddenInput()->label('') ?>
            <?= $form->field($model, 'verification_code')->textInput()->label('Код подтверждения') ?>
            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'verify-button', 'id' => 'verify-submit-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>