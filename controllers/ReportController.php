<?php

namespace app\controllers;

use app\models\Account;
use app\models\Transaction;
use app\repositories\TransactionsRepository;
use Yii;

class ReportController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionShowAccount()
    {
        $login = Yii::$app->user->identity->login;
        date_default_timezone_set ( 'Europe/Moscow');
        $trans = new TransactionsRepository();
        $trans->startDate = Yii::$app->request->post('startDate');
        $trans->finishDate = Yii::$app->request->post('finishDate');
        $choicePeriod = Yii::$app->request->post('choicePeriod');
        if ($choicePeriod != "") {
            $trans->finishDate = date('Y-m-d H:i:s');
            $trans->startDate = $this->defineStartDateByChosenPeriod($choicePeriod);
        }
        if (empty($trans->startDate)) {
            $trans->startDate = $trans->getFirstDateOfTransaction($login);
        }
        if (empty($trans->finishDate)) {
            $trans->finishDate = date('Y-m-d H:i:s');
        }
        $trans->startDate = date_create($trans->startDate)->Format('Y-m-d H:i:s');
        $trans->finishDate = date_create($trans->finishDate)->Format('Y-m-d 23:59:59');
        $consolidatedReport = Yii::$app->request->post('consolidatedReport');
        $sort = Yii::$app->request->post('sort');
        $sortWeekMonth = Yii::$app->request->post('sortWeekMonth');
        $startDate = $trans->startDate;
        $finishDate = $trans->finishDate;
        $transactionsList = $trans->consolidateTransaction($login, $sort, $sortWeekMonth);
        return $this->render('showAccount', [
            'consolidatedReport' => $consolidatedReport,
            'sort' => $sort,
            'sortWeekMonth' => $sortWeekMonth,
            'startDate' => $startDate,
            'finishDate' => $finishDate,
            'transactionsList' => $transactionsList,
        ]);
    }

    public function actionDelete()
    {
        $transaction = Transaction::findOne(['id' => Yii::$app->request->post('id')]);
        if ($transaction->type == 'debit') {
            Account::deposit($transaction->login, $transaction->summ);
        } elseif ($transaction->type == 'deposit') {
            Account::debit($transaction->login, $transaction->summ);
        }
        $transaction->delete();
    }

    private function defineStartDateByChosenPeriod($choicePeriod)
    {
        $startDate = '';
        switch ($choicePeriod) {
            case 'currentWeek':
                $startDate = date('Y-m-d H:i:s', strtotime("last Monday"));
                break;
            case 'previousWeek':
                $startDate = date('Y-m-d H:i:s', strtotime("-1 week"));
                break;
            case 'previousTwoWeeks':
                $startDate = date('Y-m-d H:i:s', strtotime("-2 week"));
                break;
            case 'previousThreeWeeks':
                $startDate = date('Y-m-d H:i:s', strtotime("-3 week"));
                break;
            case 'currentMonth':
                $startDate = date('Y-m-d H:i:s', strtotime("first day of this month"));
                break;
            case 'previousMonth':
                $startDate = date('Y-m-d H:i:s', strtotime("-1 month"));
                break;
            case 'previousTwoMonth':
                $startDate = date('Y-m-d H:i:s', strtotime("-2 month"));
                break;
            case 'previousThreeMonth':
                $startDate = date('Y-m-d H:i:s', strtotime("-3 month"));
                break;
            case 'previousFourMonth':
                $startDate = date('Y-m-d H:i:s', strtotime("-4 month"));
                break;
        }
        return $startDate;
    }

}