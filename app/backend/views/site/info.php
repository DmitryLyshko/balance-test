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
            <th></th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($bills as $bill): ?>
            <tr>
                <th scope="row"><?= Html::encode($bill->id) ?></th>
                <? if ($bill->type_id === 1):  ?>
                    <td>Предоплата</td>
                <? else :?>
                    <td>Постоплата</td>
                <? endif ?>
                <td><?= date('Y-m-d',Html::encode($bill->date_from) ) ?></td>
                <td><?= date('Y-m-d', Html::encode($bill->date_to)) ?></td>
                <td><?= Html::encode($bill->sum) ?></td>
                <td><a href="<?=Url::to(["/bill/update?client={$client->id}&bill={$bill->id}"])?>">Редактировать</a></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <a href="<?=Url::to(["bill?client={$client->id}"])?>">Добавить платеж клиента</a>
    <hr>
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
                <td><?= date('Y-m-d', Html::encode($cost->date_from)) ?></td>
                <td><?= date('Y-m-d', Html::encode($cost->date_to)) ?></td>
                <td><?= Html::encode($cost->sum) ?></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <a href="<?=Url::to(["/cost?client={$client->id}"])?>">Добавить расход для клиента</a>
</div>
