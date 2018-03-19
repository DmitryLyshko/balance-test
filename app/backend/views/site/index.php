<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="site-index">
    <p>Создание нового клиента </p>
    <? $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'type_id')->dropDownList([0 => 'Постоплата', 1 => 'Предоплата']) ?>
    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <p>Список клиентов </p>
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
                <th scope="row"><?= Html::encode($client->id) ?></th>
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
</div>
