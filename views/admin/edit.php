<?php
use app\assets\admin\AdminAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \app\models\User $user
 */
AdminAsset::register($this);
$this->title = 'Редактировать данные пользователя';
?>

<h2>Редактировать данные пользователя</h2>


<?php $form = ActiveForm::begin([
    'id' => 'users',
    'options' => ['class' => 'form-horizontal'],
]) ?>
<label style="margin-right: 50px">ID
    <?= $form->field($user, 'id', ['addAriaAttributes' => false])->textInput([
        'readOnly' => true,
        'style' => 'width:10em'
    ])
        ->label('') ?>
</label>
<label style="margin-right: 50px">Логин
    <?= $form->field($user, 'login', ['addAriaAttributes' => false])->textInput([
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
        'style' => 'width:15em'
    ])
        ->label('') ?>
</label>
<label style="margin-right: 50px">Подписка
    <?= $form->field($user, 'subscribed')
        ->dropdownList($user::SUBSCRIBED, [
            'style' => 'width:10em'
        ])
        ->label('') ?>
</label>
<label style="margin-right: 50px">Роль
    <?= $form->field($user, 'role')
        ->dropdownList($user::ROLES, [
            'style' => 'width:10em'
        ])
        ->label('') ?>
</label>
<label style="margin-right: 50px">Vk-Id
    <?= $form->field($user, 'vk_id', ['addAriaAttributes' => false])->textInput([
        'readOnly' => true,
        'style' => 'width:10em'
    ])
        ->label('') ?>
</label>
<?= Html::hiddenInput('action', 'saveEdits') ?>


<div>
    <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end() ?>


