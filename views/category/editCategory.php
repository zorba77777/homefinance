<?php

use app\assets\category\CategoryTreeAsset;
use app\widgets\categoryTree\CategoryTree;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $debitCategories array
 * @var $depositCategories array
 */

CategoryTreeAsset::register($this);
$this->title = 'Редактирование категорий';
?>

<h1>Редактировать список категорий</h1>
<p>Пожалуйста, нажмите левой кнопкой мыши на категорию, которую хотите удалить</p>

<div class="row">
    <div class="col-md-6">
        <h2>Доходные категории</h2>
        <p></p>
        <ul style="text-align: left">
            <?= CategoryTree::widget(['categoryList' => $depositCategories]) ?>
            <li id="deposit" onclick="addChild(this)" style="font-size: 10px; cursor:pointer">+добавить категорию</li>
        </ul>
    </div>
    <div class="col-md-6">
        <h2>Расходные категории</h2>
        <ul style="text-align: left">
            <?= CategoryTree::widget(['categoryList' => $debitCategories]) ?>
            <li id="debit" onclick="addChild(this)" style="font-size: 10px; cursor:pointer">+добавить категорию</li>
        </ul>
    </div>
</div>

<div class="row">
    <?= Html::a('Вернуться на главную страницу', Url::to('/main/')) ?>
</div>