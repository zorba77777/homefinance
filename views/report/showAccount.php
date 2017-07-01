<?php

use app\assets\report\ReportAsset;
use app\helpers\DateHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var string $consolidatedReport
 * @var string $sort
 * @var string $sortWeekMonth
 * @var string $startDate
 * @var string $finishDate
 * @var array $transactionsList
 */

ReportAsset::register($this);
$this->title = 'Показать отчет об операциях';
?>

<h1>Отчет о проведенных операциях</h1>
<form method="post">
    <div class="row">
        <div class="col-md-12">
            <h3>Отобразить общий отчет</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p style="font-weight: bold">Отобразить отчет об операциях между выбранными датами</p>
            <p style="line-height: 0.1em; font-size: small">Воспользуйтесь значком &#9660; чтобы отобразить календарик</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <label>Введите начальную дату:
                    <input class="btn btn-default" name="startDate" type="date" value=""/>
                </label>
            </div>
            <div class="col-md-6">
                <label>Введите конечную дату:
                    <input class="btn btn-default" name="finishDate" type="date" value=""/>
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p style="font-weight: bold; font-size: larger">или</p>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label>Выберите период, в котором происходили операции
                <select name="choicePeriod">
                    <option value=""></option>
                    <option value="currentWeek">текущая неделя</option>
                    <option value="previousWeek">предыдущая неделя</option>
                    <option value="previousTwoWeeks">предыдущие две недели</option>
                    <option value="previousThreeWeeks">предыдущие три недели</option>
                    <option value="currentMonth">текущий месяц</option>
                    <option value="previousMonth">предыдущий месяц</option>
                    <option value="previousTwoMonth">предыдущие два месяца</option>
                    <option value="previousThreeMonth">предыдущие три месяца</option>
                    <option value="previousFourMonth">предыдущие четыре месяца</option>
                </select>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label style="font-weight: bold">
                Сгруппировать операции по категориям<br/>
                <input type="radio" name="sort" value="sorted" checked="checked"> да<br/>
                <input type="radio" name="sort" value="unsorted"> нет<br/>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label style="font-weight: bold">Разбить отчет по<br/>
                <input type="radio" name="sortWeekMonth" value="week"> неделям<br/>
                <input type="radio" name="sortWeekMonth" value="month"> месяцам<br/>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input class="btn btn-default" name="consolidatedReport" type="submit" value="Отобразить отчет" size="15"
                   maxlength="15"/>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12">
        <br/>
        <?= Html::a('Вернуться на главную страницу', Url::to('/main/index')) ?>
    </div>
</div>
<div class="row">
    <div class="contain">
        <div class="col-md-12">
            <table>
                <?php
                if (($consolidatedReport == null || $sort == 'unsorted') && $sortWeekMonth == null) { ?>
                    <caption style="font-weight: bold; color: black; text-align: center">
                        Общий отчет по проведенным операциям с
                        <?= $startDate ?>
                        по
                        <?= $finishDate ?>
                    </caption>
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Сумма</th>
                        <th>Категория</th>
                        <th>Тип</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($transactionsList as $item) { ?>
                        <tr>
                            <td> <?= $item->date ?></td>
                            <td> <?= $item->summ ?></td>
                            <td> <?= $item->category ?></td>
                            <td> <?= $item->type == 'deposit' ? 'Доход' : 'Расход' ?></td>
                            <td> <?= Html::button('', [
                                    'class' => 'glyphicon glyphicon-remove',
                                    'id' => $item->id,
                                    'onclick' => 'deletion(this)'
                                    ]) ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                <?php } elseif ($sort == 'sorted' && $sortWeekMonth == null) { ?>
                    <caption style="font-weight: bold; color: black; text-align: center">Общий отчет по проведенным операциям, сгруппированным по категориям с
                        <?= $startDate ?> по
                        <?= $finishDate ?>
                    </caption>
                    <thead>
                    <tr>
                        <th>Категория</th>
                        <th>Сумма</th>
                        <th>Тип</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($transactionsList as $item) { ?>
                        <tr>
                            <td><?= $item->category ?></td>
                            <td><?= $item->summ ?></td>
                            <td><?= $item->type == 'deposit' ? 'Доход' : 'Расход' ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                <?php } elseif (($sort == 'unsorted') && ($sortWeekMonth != '')) { ?>
                    <caption style="font-weight: bold; color: black; text-align: center">Общий отчет по проведенным операциям с
                        <?= $startDate ?> по
                        <?= $finishDate ?>
                    </caption>
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Сумма</th>
                        <th>Категория</th>
                        <th>Тип</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($transactionsList as $key => $item) { ?>
                        <tr>
                            <td colspan='4' style="font-size:18px; font-weight: bold; color: red">
                                <?= $key ?>
                            </td>
                        </tr>
                        <?php foreach ($item as $keys => $value) {
                            if ($sortWeekMonth == 'week') { ?>
                                <tr>
                                    <td colspan='4' style="font-size:18px; font-weight: bold">
                                        c
                                        <?= date("d.m.Y", DateHelper::get_monday($keys, $key)) ?>
                                        по
                                        <?= date("d.m.Y", DateHelper::get_sunday($keys, $key)) ?>
                                    </td>
                                </tr>
                            <?php } elseif ($sortWeekMonth == 'month') {
                                ?>
                                <tr>
                                    <td colspan='4' style="font-size:18px; font-weight: bold">
                                        <?= $keys ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            foreach ($value as $row) {
                                ?>
                                <tr>
                                    <td><?= $row->date ?></td>
                                    <td><?= $row->summ ?></td>
                                    <td><?= $row->category ?></td>
                                    <td><?= $row->type == 'deposit' ? 'Доход' : 'Расход' ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        <?php } ?>
                    <?php } ?>
                <?php } elseif (($sort == 'sorted') && ($sortWeekMonth != null)) { ?>
                    <caption style="font-weight: bold; color: black; text-align: center">Общий отчет по проведенным операциям с
                        <?= $startDate ?>
                        по
                        <?= $finishDate ?>
                    </caption>
                    <thead>
                    <tr>
                        <th>Категория</th>
                        <th>Сумма</th>
                        <th>Тип</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($transactionsList as $key => $item) { ?>
                        <tr>
                            <td colspan='3' style="font-size:18px; font-weight: bold; color: red">
                                <?= $key ?>
                            </td>
                        </tr>
                        <?php foreach ($item as $keys => $value) {
                            if ($sortWeekMonth == 'week') { ?>
                                <tr>
                                    <td colspan='3' style="font-size:18px; font-weight: bold">
                                        c
                                        <?= date("d.m.Y", DateHelper::get_monday($keys, $key)) ?>
                                        по
                                        <?= date("d.m.Y", DateHelper::get_sunday($keys, $key)) ?>
                                    </td>
                                </tr>
                            <?php } elseif ($sortWeekMonth == 'month') { ?>
                                <tr>
                                    <td colspan='3' style="font-size:18px; font-weight: bold">
                                        <?= $keys ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php foreach ($value as $row) { ?>
                                <tr>
                                    <td><?= $row->category ?></td>
                                    <td><?= $row->summ ?></td>
                                    <td><?= $row->type == 'deposit' ? 'Доход' : 'Расход' ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        <?php }
                    }
                }
                ?>
            </table>
            <br />
            <?= Html::a('Вернуться на главную страницу', Url::to('/main/index')) ?>
            <p></p>
        </div>
    </div>
</div>
