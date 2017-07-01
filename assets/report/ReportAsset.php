<?php

namespace app\assets\report;

use yii\web\AssetBundle;

class ReportAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $css = [
        'css/report.css'
    ];
    public $js = [
        'js/report.js'
    ];
    public $depends = [

    ];
}