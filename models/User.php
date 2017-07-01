<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package app\models
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $surname
 * @property string $city
 * @property string $role
 * @property string $email
 * @property integer $subscribed
 * @property integer $vk_id
 */
class User extends ActiveRecord implements IdentityInterface
{
    const DEFAULT_ROLE = 'user';
    const ROLES = [
        'admin' => 'admin',
        'user' => 'user'
    ];

    const SUBSCRIBED = [
        '1' => '1',
        '0' => '0'
    ];

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['login', 'password', 'name', 'surname', 'city', 'email'], 'required', 'message' => 'Please, fill in this field'],
            ['login', 'hasLoginExisted'],
            [['role', 'subscribed', 'vk_id'], 'safe'],
            ['email', 'email']
        ];
    }

    public function hasLoginExisted($attribute)
    {
        $us = User::find()
            ->where(['login' => $this->{$attribute}])
            ->andWhere(['not', ['id' => $this->id]])
            ->one();
        if ($us != null) {
            $this->addError($attribute, 'Login exists');
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->role = self::DEFAULT_ROLE;
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!Account::getAccount($this->login)) {
            $categories = new Category();
            $categories->login = $this->login;
            $categories->category = 'payment';
            $categories->typeOfCategory = 'deposit';
            $categories->parent_category = 'none';
            $categories->has_child = 'no';
            $categories->position = 0;
            $categories->save();
            $categories = new Category();
            $categories->login = $this->login;
            $categories->category = 'meat';
            $categories->typeOfCategory = 'debit';
            $categories->parent_category = 'none';
            $categories->has_child = 'no';
            $categories->position = 0;
            $categories->save();
            $account = new Account();
            $account->login = $this->login;
            $account->summ = 0;
            $account->save();
        }
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return true;
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }
}