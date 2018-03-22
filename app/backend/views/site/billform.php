<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bill */
/* @var $form ActiveForm */

?>

<div class="billform">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'client_id')->hiddenInput(['value' => $client_id])->label('') ?>
        <?= $form->field($model, 'type_id')->dropDownList([0 => 'Постоплата', 1 => 'Предоплата']) ?>
        <?= $form->field($model, 'sum')->label('Сумма') ?>
        <?= $form->field($model, 'date_from')
            ->widget(
                'trntv\yii\datetime\DateTimeWidget',
                ['phpDatetimeFormat' => 'yyyy-MM-dd'])
            ->label('Дата начала')
        ?>
        <?= $form->field($model, 'date_to')
            ->widget('trntv\yii\datetime\DateTimeWidget',
                ['phpDatetimeFormat' => 'yyyy-MM-dd'])
            ->label('Дата завершения')
        ?>
        <div class="form-group">
            <?= Html::submitButton('Создать платеж', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
