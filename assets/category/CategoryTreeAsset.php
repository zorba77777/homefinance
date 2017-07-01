<?php

namespace app\assets\category;

use yii\web\AssetBundle;

class CategoryTreeAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $css = [
        'css/category.css'
    ];
    public $js = [
        'js/categoryTree.js'
    ];
    public $depends = [

    ];
}