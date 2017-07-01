<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\User;
use Yii;

class AuthenticationController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $login = $model->login;
            $user = User::findOne(['login' => $login]);
            Yii::$app->user->login($user);
            return $this->goBack();
        } else {
            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionReg($vkId = null, $vkName = null, $vkSurname = null)
    {
        $message = '';
        $user = new User();
        if ($vkId) {
            $user->vk_id = $vkId;
            $user->name = $vkName;
            $user->surname = $vkSurname;
            $message = 'Please, fill in the rest information to complete the registration';
        }
        if ($user->load(\Yii::$app->request->post()) && $user->validate()) {
            $user->password = password_hash($user->password, PASSWORD_DEFAULT);
            $user->save();
            Yii::$app->user->login($user);
            echo 'Registration has completed successfully. You will be redirected to the main page of the site in 5 seconds';
            header('Refresh: 5; URL=' . Yii::$app->request->hostInfo . '/main/index');
            exit;
        } else {
            return $this->render('reg', [
                'user' => $user,
                'message' => $message
                ]);
        }
    }

    public function actionEdit()
    {
        $login = Yii::$app->user->identity->login;
        $user = User::findOne(['login' => $login]);
        if ($user->load(\Yii::$app->request->post()) && $user->validate()) {
            if (Yii::$app->request->post('pass') != '') {
                $user->password = password_hash(Yii::$app->request->post('pass'), PASSWORD_DEFAULT);
            }
            $user->save();
            return $this->redirect(['main/index']);
        } else {
            return $this->render('edit', [
                'user' => $user
            ]);
        }
    }

    public function actionVkontakte()
    {
        $userData = Yii::$app->request->post('userData');
        $md5 = md5(Yii::$app->params['vkAuth']['appId'] . $userData['uid'] . Yii::$app->params['vkAuth']['secretKey']);
        if ($userData['hash'] != $md5) {
            return 'Failure';
        }

        $user = User::findOne(['vk_id' => $userData['uid']]);
        if (!$user) {
            return 'User didn\'t exist';
        } else {
            Yii::$app->user->login($user);
            return 'Success';
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}