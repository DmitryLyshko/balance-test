<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Test Application';
?>

<div class="site-index">
    <p>Balance: <mark><?= Html::encode($balance) ?></mark></p>
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?=Url::to(['site/'])?>">Платежи</a></li>
        <li><a href="<?=Url::to(['site/costs'])?>">Расходы</a></li>
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
