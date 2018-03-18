<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Costs';
?>

<div class="site-index">
    <p>Balance: <mark><?= Html::encode($balance) ?></mark></p>
    <ul class="nav nav-tabs">
        <li><a href="/">Платежи</a></li>
        <li class="active"><a href="/index.php?r=site%2Fcosts">Расходы</a></li>
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