<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Account
 * @package app\models
 * @property string $login
 * @property integer $summ
 */

class Account extends ActiveRecord
{
    public static function tableName()
    {
        return 'balance';
    }

    public function rules()
    {
        return [
            [['login', 'summ'], 'safe'],
            [['summ'], 'required', 'message' => 'Please, fill in this field']
        ];
    }

    public static function getAccount($login)
    {
        $account = Account::find()
            ->where(['login' => $login])
            ->one();
        return $account;
    }

    public static function getBalance($login)
    {
        $account = Account::find()
            ->where(['login' => $login])
            ->one();
        return $account->summ;
    }

    public static function deposit($login, $summ)
    {
        $account = Account::find()
            ->where(['login' => $login])
            ->one();
        $account->summ += $summ;
        $account->save();
    }

    public static function debit($login, $summ)
    {
        $account = Account::find()
            ->where(['login' => $login])
            ->one();
        $balance = $account->summ;
        if (($balance - $summ) < 0) {
            return false;
        } else {
            $account->summ -= $summ;
            $account->save();
            return true;
        }
    }
}
