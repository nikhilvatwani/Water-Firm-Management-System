<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\models\Type;
use yii\helpers\ArrayHelper;
use backend\models\Bottle;
use backend\models\Cane;
/* @var $this yii\web\View */
/* @var $model backend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
           function ab(ref){
                //alert("hi");
                var n = $(ref).attr('id');
                n = n.charAt(5);
                console.log(n);
                $('#rate-'+n+'-company').empty();
                var type = $(ref).val();
                console.log(type);
                     $.ajax({
                        url: 'http://localhost/advanced_old/backend/web/index.php?r=rate/temp&type='+type,
                        dataType: "json",
                        context:ref,    
                        success: function(data) {
                            var obj = data;
                            var t = ref;
                            $(obj).each(function(key,value){
                                    //console.log($(t).parent().parent().next('td').children().children().attr("class"));
                                if(type==1){
                                    $('#rate-'+n+'-company').append($('<option>', { value: value["cane_id"],text: value["name"]}));
                                }else if(type == 2){
                                    $('#rate-'+n+'-company').append($('<option>', { value: value["bottle_id"],text: value["name"]+"("+value["quantity"]+")"}));
                                }
                            });
                        }
                    })
            }

</script>
<div class="customer-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

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
            'po_item_no',
            'quantity',
          
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
                        <h3 class="panel-title pull-left">Rate</h3>
                        <div class="pull-right">
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelRate->isNewRecord) {
                                echo Html::activeHiddenInput($modelRate, "[{$i}]rate_id");
                            }
                        ?>

                        <div class="row">
                            <div class="col-sm-4">
                                <?php
                                    $types = ArrayHelper::map(Type::find()->orderBy('type_name')->asArray()->all(),'type_id','type_name');
                                    $types = array("0" => "Select type") + $types;
                                    echo $form->field($modelRate, "[{$i}]type")->dropDownList($types,["onchange"=>"ab(this)"]);
                                 ?>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                    $company = []; 
                                    if (! $modelRate->isNewRecord) {
                                        if($modelRate->type == '1')
                                            $temp = 'cane';
                                        else if($modelRate->type == '2')
                                            $temp = 'bottle';
                                        $name = "backend\models\\".ucwords($temp);
                                        $company = $name::findOne([$temp.'_id'=>$modelRate->company]);
                                        $company = array($company[$temp.'_id']=>$company->name);

                                     }

                                    echo $form->field($modelRate, "[{$i}]company")->dropDownList($company);
                                ?>
                            </div>
                            <div class="col-sm-4">
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
