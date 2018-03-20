<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Client №{$client->id}";
?>

<div class="site-index">
    <p>Balance: <mark><?= Html::encode($balance) ?></mark></p>


    <p>Платежи</mark></p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Номер</th>
            <th>Тип платежа</th>
            <th>Дата начала</th>
            <th>Дата завершения</th>
            <th>Сумма</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($bills as $bill): ?>
            <tr>
                <th scope="row"><?= Html::encode($bill->id) ?></th>
                <td><?= Html::encode($bill->type_id) ?></td>
                <td><?= Html::encode($bill->date_from) ?></td>
                <td><?= Html::encode($bill->date_to) ?></td>
                <td><?= Html::encode($bill->sum) ?></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <p>Расходы</mark></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Номер</th>
            <th>Дата начала</th>
            <th>Дата завершения</th>
            <th>Сумма</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($costs as $cost): ?>
            <tr>
                <th scope="row"><?= Html::encode($cost->id) ?></th>
                <td><?= Html::encode($cost->date_from) ?></td>
                <td><?= Html::encode($cost->date_to) ?></td>
                <td><?= Html::encode($cost->sum) ?></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <a href="">Добавить расход для клиента</a>
</div>
