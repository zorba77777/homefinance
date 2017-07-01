<?php

namespace app\assets\authentication;

use yii\web\AssetBundle;

class AuthenticationAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $css = [
        'css/authentication.css'
    ];
    public $js = [
        'js/authentication.js'
    ];
    public $depends = [

    ];
}