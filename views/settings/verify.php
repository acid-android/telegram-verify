<?php
\app\assets\VerifyAsset::register($this);

$this->title = 'Двухфакторная аутентификация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-10" id="verification_container">

    <table class="table">
        <tbody>
        <tr>
            <td>Верификация через Telegram</td>
            <td>
                <?= \app\utilities\Verification\setup\VerificationSetUp::getVerificationStateInfo( \app\utilities\Verification\VerificationTypes::TFA_TYPE_TELEGRAM) ?>
            </td>
            <td><button class="btn btn-success" id="tg-tfa-set" data-url="set-up-telegram-tfa">Настроить</button></td>
        </tr>
        <tr>
            <td>Верификация через Google Authenticator</td>
            <td>
                <?= \app\utilities\Verification\setup\VerificationSetUp::getVerificationStateInfo( \app\utilities\Verification\VerificationTypes::TFA_TYPE_GOOGLE_AUTH) ?>
            </td>
            <td><button class="btn btn-success" id="google-tfa-set" data-url="set-up-google-tfa">Настроить</button></td>
        </tr>
        </tbody>
    </table>
</div>
