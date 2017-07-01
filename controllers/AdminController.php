<?php

namespace app\controllers;

use app\models\Account;
use app\models\Category;
use app\models\search\UserSearch;
use app\models\Settings;
use app\models\Transaction;
use app\models\User;
use Yii;
use yii\helpers\Json;

class AdminController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionAdmin()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('users', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionEdit($login)
    {
        $user = User::findOne(['login' => $login]);
        if ($user->load(\Yii::$app->request->post()) && $user->validate()) {
            $user->save();
            return $this->redirect(['admin/admin']);
        } else {
            return $this->render('edit', [
                'user' => $user
            ]);
        }
    }

    public function actionDelete($login)
    {
        User::deleteAll(['login' => $login]);
        Transaction::deleteAll(['login' => $login]);
        Category::deleteAll(['login' => $login]);
        Account::deleteAll(['login' => $login]);
        return $this->redirect(['admin/admin']);
    }

    public function actionLetter()
    {
        $group = Settings::getGroup('letter');
        if (!$group) {
            $group = new Settings();
            $group->group = 'letter';
            $group->data = $letterText = [
                'subject' => 'Week report',
                'text' => 'Week report',
                'type' => 'excel'
            ];
            $group->save();
        }
        if (Yii::$app->request->post('submit')) {
            $group->set('subject', Yii::$app->request->post('subject'));
            $group->set('text', Yii::$app->request->post('text'));
            $group->set('type', Yii::$app->request->post('type'));
            $letterText = $group->data;
            $group->save();
        } else {
            $letterText = $group->data;
        }
        return $this->render('letter', [
            'letterText' => $letterText
        ]);
    }
}