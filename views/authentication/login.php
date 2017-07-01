<?php
use app\assets\authentication\AuthenticationAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var \app\models\LoginForm $model
 */
AuthenticationAsset::register($this);
$this->title = 'Вход на сайт';

?>
<div id="vk_auth" style="float: right"></div>
<div style="position: absolute; margin-left: 35%">
    <h2>Вход на сайт</h2>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
    <label>Логин
        <?= $form->field($model, 'login')->textInput([
            'style' => 'width:10em'
        ])->label('') ?>
    </label>
    <br/>
    <label>Пароль
        <?= $form->field($model, 'password')->passwordInput([
            'style' => 'width:10em'
        ])->label('') ?>
    </label>
    <div>
        <div>
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
    <?= Html::a('Регистрация', Url::to('/authentication/reg')) ?>
</div>
<p id="message"></p>