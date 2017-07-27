<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'o_id') ?>

    <?= $form->field($model, 'c_id') ?>

    <?= $form->field($model, 'type_id') ?>

    <?= $form->field($model, 'cane_id') ?>

    <?= $form->field($model, 'bottle_id') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'amount_paid') ?>

    <?php // echo $form->field($model, 'amount_pending') ?>

    <?php // echo $form->field($model, 'cane_pending') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
