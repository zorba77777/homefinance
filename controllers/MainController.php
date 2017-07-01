<?php

namespace app\controllers;

use app\models\Account;
use app\models\Category;
use app\models\Transaction;
use app\models\User;
use Yii;


class MainController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $login = Yii::$app->user->identity->login;
        $transaction = new Transaction();
        if ($transaction->load(Yii::$app->request->post())) {
            $transaction->login = $login;
            date_default_timezone_set ( 'Europe/Moscow');
            $transaction->date = date('Y-m-d H:i:s');
            if (!Yii::$app->request->post('category')) {
                $transaction->category = 'undefined';
            } else {
                $category = Category::find()
                    ->where(['id' => Yii::$app->request->post('category')])
                    ->one();
                $transaction->category = $category->category;
            }
            if ($transaction->validate()) {
                $transaction->save();
            }
        }
        $transaction->date = '';
        $transaction->summ = '';
        $transaction->category = '';
        $transaction->type = '';
        $balance = Account::getBalance($login);
        return $this->render('index', [
            'login' => $login,
            'balance' => $balance,
            'transaction' => $transaction
        ]);
    }

    public function actionShowCategories()
    {
        $login = Yii::$app->request->post('login');
        $type = Yii::$app->request->post('type');
        $output = Category::find()
            ->where(['login' => $login])
            ->andWhere(['typeOfCategory' => $type])
            ->andWhere(['parent_category' => 'none'])
            ->all();
        return $this->renderAjax('showCategories', [
            'output' => $output,
            'type' => $type
        ]);
    }

    public function actionShowSubcategories()
    {
        $login = Yii::$app->request->post('login');
        $type = Yii::$app->request->post('type');
        $parent = Yii::$app->request->post('parent');
        $output = Category::find()
            ->where(['login' => $login])
            ->andWhere(['typeOfCategory' => $type])
            ->andWhere(['parent_category' => $parent])
            ->all();
        return $this->renderAjax('showCategories', [
            'output' => $output,
            'type' => $type
        ]);
    }

    public function actionSubscribe()
    {
        $login = Yii::$app->request->post('login');
        $message = 'You are already subscribed to the mailing';

        /** @var User $out */
        $out = User::find()
            ->where(['login' => $login])
            ->one();
        if ($out->subscribed == 0) {
            $output = shell_exec('crontab -l');
            file_put_contents('/tmp/crontab.txt', $output . '30 5 * * 1 /var/www/homefinance/yii send/send ' . $login . PHP_EOL);
            exec('crontab /tmp/crontab.txt');
            $out->subscribed = 1;
            $out->save();
            $message = 'You have subscribed to the mailing';
        }
        return $message;
    }
}