<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Costs';
?>

<div class="site-index">
    <p>Balance: <mark><?=Html::encode($balance) ?></mark></p>
    <ul class="nav nav-tabs">
        <li><a href="<?=Url::to(['site/?id=' . Yii::$app->request->get('id')])?>">Платежи</a></li>
        <li class="active"><a href="<?=Url::to(['site/costs/?id=' . Yii::$app->request->get('id')])?>">Расходы</a></li>
    </ul>
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
</div>