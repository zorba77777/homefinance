<?php

namespace app\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['admin', 'edit', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role == 'admin') {
                                return true;
                            } else {
                                return $this->goHome();
                            }
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login', 'reg', 'vkontakte'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login', 'reg'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->goHome();
                        }
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}