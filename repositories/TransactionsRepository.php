<?php

namespace app\repositories;

use app\models\Transaction;

/**
 * Class TransactionsRepository
 * @package app\repositories
 * @property string $startDate
 * @property string $finishDate
 */
class TransactionsRepository
{
    public $startDate;
    public $finishDate;

    public function consolidateTransaction($login, $sorted = '', $sortWeekMonth = '')
    {
        $modelsArray = $this->findByLoginAndDates($login, $this->startDate, $this->finishDate);
        $modelsArray = $this->orderingToDate($modelsArray);
        if ($sortWeekMonth == 'week') {
            $modelsArray = $this->createArrayOfWeeks($modelsArray);
        } elseif ($sortWeekMonth == 'month') {
            $modelsArray = $this->createArrayOfMonths($modelsArray);
        }
        if ($sorted == 'sorted' && $sortWeekMonth == null) {
            $modelsArray = $this->consolidateToCategories($modelsArray);
        } elseif ($sorted == 'sorted' && $sortWeekMonth != null) {
            foreach ($modelsArray as $key => $value) {
                foreach ($value as $keys => $item) {
                    $modelsArray[$key][$keys] = $this->consolidateToCategories($modelsArray[$key][$keys]);
                }
            }
        }
        return $modelsArray;
    }

    private function cutPeriod($array, $startDate, $finishDate)
    {
        $cutArray = [];
        $startDate = strtotime($startDate);
        $finishDate = strtotime($finishDate);
        foreach ($array as $value) {
            if ((strtotime($value->date) >= $startDate) &&
                (strtotime($value->date) <= $finishDate)
            ) {
                $cutArray[] = $value;
            }
        }
        return $cutArray;
    }

    private function orderingToDate($array)
    {
        usort($array, function ($f1, $f2) {
            if (strtotime($f1->date) < strtotime($f2->date)) return -1;
            elseif (strtotime($f1->date) > strtotime($f2->date)) return 1;
            else return 0;
        });
        return $array;
    }

    private function consolidateToCategories($array)
    {
        $array2 = $array;
        while (list($k1, $v1) = each($array)) {
            foreach ($array2 as $k2 => $v2) {
                if ($k1 === $k2) continue;
                if ($v1->category == $v2->category) {
                    $v1->summ = $v1->summ + $v2->summ;
                    unset ($array[$k2], $array2[$k2]);
                }
            }
        }
        return $array;
    }

    private function createArrayOfWeeks($array)
    {
        $arrayOfYears = $this->createArrayofYears($array);
        foreach ($arrayOfYears as $key => $value) {
            $start = $key . '-01-01 00:00:00';
            $finish = $key . '-12-31 23:59:59';
            $firstWeek = $key . '-01-07 00:00:00';
            $temperArray = $this->cutPeriod($array, $start, $finish);
            $arrayOfWeeks = [];
            foreach ($temperArray as $item) {
                if (
                    (strtotime($item->date) <= strtotime($firstWeek)) &&
                    ((date('W', strtotime($item->date)) == 51) ||
                        (date('W', strtotime($item->date))) == 52)
                ) {
                    $arrayOfWeeks[] = 0;
                } else {
                    $arrayOfWeeks[] = date('W', strtotime($item->date));
                }
            }
            $arrayOfWeeks = array_unique($arrayOfWeeks);
            $arrayOfWeeks = array_flip($arrayOfWeeks);
            if (isset ($arrayOfWeeks[0])) {
                $arrayOfWeeks[0] = [];
            }
            foreach ($arrayOfWeeks as $keys => $values) {
                $arrayOfWeeks[$keys] = [];
                foreach ($temperArray as $item) {
                    if (
                        (strtotime($item->date) <= strtotime($firstWeek)) &&
                        ((date('W', strtotime($item->date)) == 51) ||
                            (date('W', strtotime($item->date))) == 52)
                    ) {
                        $arrayOfWeeks[0][] = $item;
                    } elseif ($keys == date('W', strtotime($item->date))) {
                        $arrayOfWeeks[$keys][] = $item;
                    }
                }
                if (isset ($arrayOfWeeks[0])) {
                    $arrayOfWeeks[0] = array_unique($arrayOfWeeks[0]);
                }
            }
            $arrayOfYears[$key] = $arrayOfWeeks;
        }
        return $arrayOfYears;
    }

    private function createArrayOfMonths($array)
    {
        $arrayOfYears = $this->createArrayofYears($array);
        foreach ($arrayOfYears as $key => $value) {
            $start = $key . '-01-01 00:00:00';
            $finish = $key . '-12-31 23:59:59';
            $temperArray = $this->cutPeriod($array, $start, $finish);
            $arrayOfMonths = [];
            foreach ($temperArray as $item) {
                $arrayOfMonths[] = date('M', strtotime($item->date));
            }
            $arrayOfMonths = array_unique($arrayOfMonths);
            $arrayOfMonths = array_flip($arrayOfMonths);
            foreach ($arrayOfMonths as $keys => $values) {
                $arrayOfMonths[$keys] = array();
                foreach ($temperArray as $item) {
                    if ($keys == date('M', strtotime($item->date))) {
                        $arrayOfMonths[$keys][] = $item;
                    }
                }
            }
            $arrayOfYears[$key] = $arrayOfMonths;
        }
        return $arrayOfYears;
    }

    private function createArrayOfYears($array)
    {
        $arrayOfYears = [];
        foreach ($array as $value) {
            $arrayOfYears[] = date('Y', strtotime($value->date));
        }
        $arrayOfYears = array_unique($arrayOfYears);
        $arrayOfYears = array_flip($arrayOfYears);
        foreach ($arrayOfYears as $key => $value) {
            $arrayOfYears[$key] = [];
        }
        return $arrayOfYears;
    }

    public function getFirstDateOfTransaction($login)
    {
        $res = Transaction::find()
            ->where(['login' => $login])
            ->orderBy(['date' => SORT_ASC])
            ->one();
        if ($res == null) {
            $result = date('Y-m-d H:i:s');
        } else {
            $result = date_create($res->date)->Format('Y-m-d H:i:s');
        }
        return $result;
    }

    private function findByLoginAndDates($login, $startDate, $finishDate)
    {
        $transactions = Transaction::find()
            ->where(['login' => $login])
            ->andWhere(['>=', 'date', $startDate])
            ->andWhere(['<=', 'date', $finishDate])
            ->all();
        return $transactions;
    }
}

