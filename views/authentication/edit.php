<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \app\models\User $user
 */

$this->title = 'Изменение данных';
?>

<div style="text-align: center">
<h2>Редактировать свои регистрационные данные</h2>

<h3>Ваш логин <?= $user->login ?></h3>

<?php $form = ActiveForm::begin([
    'id' => 'users',
    'options' => ['class' => 'form-horizontal'],
]) ?>

<label style="margin-right: 50px; line-height: 2.3; text-align: center" class="control-label">Пароль
    <input name="pass" type="password" class="form-control" placeholder="введите новый пароль">
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
        'style' => 'width:15em'
    ])
        ->label('') ?>
</label>

<?= Html::hiddenInput('action', 'saveEdits') ?>

<div>
    <?= Html::submitButton('Сохранить изменения и вернуться на главную страницу', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>
</div>