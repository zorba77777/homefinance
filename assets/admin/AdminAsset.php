<?php

namespace app\assets\admin;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $css = [
        'css/admin.css'
    ];
    public $js = [
        'js/admin.js'
    ];
    public $depends = [

    ];
}