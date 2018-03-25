<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Test Application';
?>

<div class="site-index">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id клиента</th>
            <th>Тип платежа</th>
            <th>Баланс</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($clients as $client): ?>
            <tr>
                <th scope="row"><a href="<?=Url::to(["/?id={$client->id}"])?>"><?= Html::encode($client->id) ?></a></th>
                <? if ($client->type_id === 1):  ?>
                    <td>Предоплата</td>
                <? else :?>
                    <td>Постоплата</td>
                <? endif ?>
                <td><?= Html::encode($client->getBalances()->one()->sum) ?></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <p>Balance: <mark><?= Html::encode($balance) ?></mark></p>
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?=Url::to(['site/'])?>">Платежи</a></li>
        <li><a href="<?=Url::to(['site/costs/?id=' . Yii::$app->request->get('id')])?>">Расходы</a></li>
    </ul>
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
</div>
