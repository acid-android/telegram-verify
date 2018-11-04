<?php

namespace app\assets;


use yii\web\AssetBundle;

class VerifyAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/src';
    public $js= [
        'settings/verify/verify.js'
    ];

    public $depends = [
        'app\assets\AppAsset'
    ];


}