<?php

use app\assets\main\MainAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var int $balance
 * @var string $login
 * @var \app\models\Transaction $transaction
 * @var string $message
 */
MainAsset::register($this);
$this->title = 'Провести операцию';
?>
<h1>Домашняя бухгалтерия</h1>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4" style="text-align: left">
                <p>Баланс
                    <?php if ($balance == 0): ?>
                        0
                    <?php else: ?>
                        <?= $balance ?>
                    <?php endif ?>
                    руб.</p>
            </div>
            <div class="col-md-4">
                <h3>Провести операцию</h3>
            </div>
            <div class="col-md-4">
                <p>Вы вошли как <span id="login"><?= $login ?></span></p>
                <?= Html::a('Изменить свои данные', Url::to('/authentication/edit')) ?>
                <?= Html::a('Выйти', Url::to('/authentication/logout')) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            $form = ActiveForm::begin([
                'id' => 'transaction',
                'options' => ['class' => 'form-horizontal',
                    'onsubmit' => 'return validateForm(this);'],
            ])
            ?>

            <?= $form->field($transaction, 'summ')
                ->textInput(['class' => 'inp',
                    'onkeyup' => 'return check(this);',
                    'onchange' => 'return check(this);'])
                ->label('Провести операцию на сумму'); ?>

            <p>Выберите вид операции</p>
            <?= $form->field($transaction, 'type')->radio([
                'label' => 'Доходная',
                'value' => 'deposit',
                'id' => 'radioDeposit',
                'uncheck' => null,
            ]) ?>
            <?= $form->field($transaction, 'type')->radio([
                'label' => 'Расходная',
                'value' => 'debit',
                'id' => 'radioDebit',
                'uncheck' => null,
            ]) ?>

            <p id="mustSelectType" class="warning"></p>

            <div id="categorySelect"></div>
            <div><br/></div>

            <?= Html::submitButton('Провести операцию', ['class' => 'btn btn-primary']) ?>

            <?php ActiveForm::end() ?>
        </div>
    </div>
    <?= Html::a('Редактировать категории', Url::to('/category/edit-category')) ?>
    <?= Html::a('Показать отчет об операциях', Url::to('/report/show-account')) ?>
</div>
<br />
<div class="row" style="float: left; width: 600px">
    <div class="col-md-6">
        <label style="font-weight: normal">Подписаться на еженедельную рассылку о проведенных операциях<br/><br/>
            <button style="font-weight: normal" type="button">Подписаться</button>
            <br/><br/>
            <p id="message"></p>
        </label>
    </div>
</div>