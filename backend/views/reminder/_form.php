<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Reminder */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div class="reminder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'what')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'dateandtime')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd','value' => date('Y-m-d')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
