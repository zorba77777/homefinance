<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \app\models\User $user
 * @var string $message
 */

$this->title = 'Регистрация';
?>

<h2>Registration</h2>
<p><?= $message ?></p>

<?php $form = ActiveForm::begin([
    'id' => 'users',
    'options' => ['class' => 'form-horizontal'],
]) ?>
<label style="margin-right: 50px">Логин
    <?= $form->field($user, 'login', ['addAriaAttributes' => false])->textInput([
        'style' => 'width:10em'
    ])
        ->label('') ?>
</label>
<label style="margin-right: 50px">Пароль
    <?= $form->field($user, 'password', ['addAriaAttributes' => false])->passwordInput([
        'style' => 'width:10em'
    ])
        ->label('') ?>
</label>
<label style="margin-right: 50px">Имя
    <?= $form->field($user, 'name', ['addAriaAttributes' => false])->textInput([
        'style' => 'width:10em'
    ])
        ->label('') ?>
</label>
<label style="margin-right: 50px">Фамилия
    <?= $form->field($user, 'surname', ['addAriaAttributes' => false])->textInput([
        'style' => 'width:10em'
    ])
        ->label('') ?>
</label>
<label style="margin-right: 50px">Город
    <?= $form->field($user, 'city', ['addAriaAttributes' => false])->textInput([
        'style' => 'width:10em'
    ])
        ->label('') ?>
</label>
<label style="margin-right: 50px">Email
    <?= $form->field($user, 'email', ['addAriaAttributes' => false])->textInput([
        'style' => 'width:10em'
    ])
        ->label('') ?>
</label>

<div>
    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>

