<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\models\Type;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rate-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
      <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'rate')->textInput(['rows' => 6]) ?>

     <div class="row">
        <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 4, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsRate[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'type',
            'company',
            'rate',
        ],
    ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>
                <i class="glyphicon glyphicon-envelope"></i> Rates
                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</button>
            </h4>
        </div>
        <div class="panel-body">
            <div class="container-items"><!-- widgetBody -->
            <?php foreach ($modelsRate as $i => $modelRate): ?>
                <div class="item panel panel-default"><!-- widgetItem -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Rates</h3>
                        <div class="pull-right">
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelRate->isNewRecord) {
                                echo Html::activeHiddenInput($modelRate, "[{$i}]id");
                            }
                        ?>

                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                //$types = ArrayHelper::map(Type::find()->orderBy('type_name')->asArray()->all(),'type_id','type_name');
                                //$types = array("0" => "Select type") + $types;
                                echo $form->field($modelRate, "[{$i}]type")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                $company = [];
                                echo $form->field($modelRate, "[{$i}]company")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelRate, "[{$i}]rate")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div><!-- .panel -->
    <?php DynamicFormWidget::end(); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
