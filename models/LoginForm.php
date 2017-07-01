<?php

namespace app\models;

use yii\base\Model;

/**
 * Class LoginForm
 * @package app\models
 * @property string $login
 * @property string $password
 */

class LoginForm extends Model
{
    public $login;
    public $password;

    public function rules()
    {
        return [
            [['login', 'password'], 'required', 'message' => 'Please, fill in this field'],
            ['login', 'hasLoginExisted'],
            ['password', 'isPasswordCorrect']
        ];
    }

    public function hasLoginExisted($attribute)
    {
        $user = User::findOne(['login' => $this->{$attribute}]);
        if ($user == null) {
            $this->addError($attribute, 'Login doesn\'t exist');
        }
    }

    public function isPasswordCorrect($attribute)
    {
        $user = User::findOne(['login' => $this->login]);
        if ($user == null) {
            return true;
        } else {
            $openPassword = $this->{$attribute};
            $closePassword = $user->password;
            if (!password_verify($openPassword, $closePassword)) {
                $this->addError($attribute, 'Incorrect password');
            }
        }
    }
}