<?php

use \yii\helpers\Html;

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="list-group submenu">
        <li class="list-group-item">
            <span class="title">Двухфакторная аутентификация</span>
            <span class="action">
                <a class="btn btn-success" href="<?= \yii\helpers\Url::to('settings/tfa') ?>">Настроить</a>
            </span>
        </li>
    </ul>
</div>
