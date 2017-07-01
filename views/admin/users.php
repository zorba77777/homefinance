<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\UserSearch $searchModel
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Список пользователей';
?>
    <div class="container">
        <div class="row">
            <div class="col-md-6" style="margin-left: 16%">
                <h1>Список пользователей</h1>
            </div>
            <div class="col-md-4" style="float: right">
                <?= Html::a('Редактировать текст сопроводительного письма', Url::to('/admin/letter')) ?>
            </div>
        </div>
    </div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'login',
        'name',
        'surname',
        'city',
        'role',
        'email',
        'subscribed',
        'vk_id',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'template' => '{view}{delete}',
            'buttons' => [
                'view' => function ($url, $users) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-edit"></span>',
                        Url::to(['/admin/edit', 'login' => $users['login']]),
                        ['title' => Yii::t('app', 'edit')]
                    );
                },

                'delete' => function ($url, $users) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-remove"></span>',
                        Url::to(['/admin/delete', 'login' => $users['login']]),
                        ['title' => Yii::t('app', 'delete')]
                    );
                }
            ],
        ],
    ]
]) ?>