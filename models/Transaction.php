<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Transaction
 * @package app\models
 * @property string $login
 * @property string $category
 * @property string $type
 * @property int $summ
 * @property string $date
 */
class Transaction extends ActiveRecord
{

    public static function tableName()
    {
        return 'transactions';
    }

    public function rules()
    {
        return [
            [['login', 'summ', 'category', 'type'], 'safe'],
            [['summ'], 'required', 'message' => 'Please, fill in this field'],
            ['summ', 'isBalanceNegative']
        ];
    }

    public function isBalanceNegative($attribute)
    {
        $balance = Account::getBalance($this->login);
        if ($this->type == 'debit') {
            if (($balance - $this->{$attribute}) < 0) {
                $this->addError($attribute, 'You cannot spend expenditure transactions
                     for an amount higher than your account balance.');
            }
        }
    }

    public function __toString()
    {
        return $this->date;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->type == 'debit') {
            Account::debit($this->login, $this->summ);
        } elseif ($this->type == 'deposit') {
            Account::deposit($this->login, $this->summ);
        }
    }
}