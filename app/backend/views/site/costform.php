<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Costs */
/* @var $form ActiveForm */
?>
<div class="costclient">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'client_id')->hiddenInput(['value' => $client_id])->label('') ?>
        <?= $form->field($model, 'sum')->label('Сумма') ?>
        <?= $form->field($model, 'date_from')->widget(
                'trntv\yii\datetime\DateTimeWidget',
                 ['phpDatetimeFormat' => 'yyyy-MM-dd'])
            ->label('Дата начала') ?>
        <?= $form->field($model, 'date_to')->widget(
                'trntv\yii\datetime\DateTimeWidget',
                ['phpDatetimeFormat' => 'yyyy-MM-dd']
        )->label('Дата завершения') ?>

        <div class="form-group">
            <?= Html::submitButton('Создать платеж', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
