<?php

namespace app\assets\main;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $css = [
        'css/main.css'
    ];
    public $js = [
        'js/main.js'
    ];
    public $depends = [

    ];
}