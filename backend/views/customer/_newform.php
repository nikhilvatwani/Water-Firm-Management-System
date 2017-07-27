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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
           function ab(ref){
                //alert("hi");
                $(ref).parent().parent().next('td').children().children().empty();
                console.log($(ref).parent().parent().next('td').children().children().attr("class"));
                var type = $(ref).val();
                console.log(type);
                     $.ajax({
                        url: 'http://localhost/advanced_old/backend/web/index.php?r=rate/temp&type='+type,
                        dataType: "json",
                        context:typ,    
                        success: function(data) {

                            var obj = data;
                            var t = ref;
                            $(obj).each(function(key,value){
                                    //console.log($(t).parent().parent().next('td').children().children().attr("class"));
                                if(type==1){
                                    $(t).parent().parent().next('td').children().children().append($('<option>', { value: value["cane_id"],text: value["name"]}));
                                }else if(type == 2){
                                    $(t).parent().parent().next('td').children().children().append($('<option>', { value: value["bottle_id"],text: value["name"]}));
                                }
                            });
                        }
                    })
            }

</script>
<div class="customer-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?php DynamicFormWidget::begin([

        'widgetContainer' => 'dynamicform_wrapper',

        'widgetBody' => '.container-items',

        'widgetItem' => '.house-item',

        'limit' => 10,

        'min' => 1,

        'insertButton' => '.add-house',

        'deleteButton' => '.remove-house',

        'model' => $modelRate[0],

        'formId' => 'dynamic-form',

        'formFields' => [

            'description',

        ],

    ]); ?>

    <table class="table table-bordered table-striped">

        <thead>

            <tr>

                <th>Type</th>

                <th>Company</th>

                <th>Price</th>

                <th class="text-center" style="width: 90px;">

                    <button type="button" class="add-house btn btn-success btn-xs"><span class="fa fa-plus"></span></button>

                </th>

            </tr>

        </thead>

        <tbody class="container-items">

        <?php foreach ($modelRate as $key => $value): ?>

            <tr class="house-item">

                <td class="vcenter">

                    <?php

                        // necessary for update action.

                        if (! $value->isNewRecord) {

                            echo Html::activeHiddenInput($value, "type");

                        }

                    ?>

                    <?php 
                        $types = ArrayHelper::map(Type::find()->orderBy('type_name')->asArray()->all(),'type_id','type_name');
                        $types = array("0" => "Select type") + $types;
                        echo $form->field($value, 'type')->label(false)->dropDownList($types,["class"=>"form-control rate-type","onchange"=>"ab(this)"]);
                     ?>

                </td>

                <td class="abc">

                     <?php

                        // necessary for update action.

                        if (! $value->isNewRecord) {

                            echo Html::activeHiddenInput($value, "company");

                        }

                    ?>

                    <?php
                        $company = [];
                        echo $form->field($value, "company")->label(false)->dropDownList($company,["class"=>"form-control rate-company"]) ?>

                </td>
                <td>

                     <?php

                        // necessary for update action.

                        if (! $value->isNewRecord) {

                            echo Html::activeHiddenInput($value, "rate");

                        }

                    ?>

                    <?= $form->field($value, "rate")->label(false)->textInput(['maxlength' => true]) ?>

                </td>

                <td class="text-center vcenter" style="width: 90px; verti">

                    <button type="button" class="remove-house btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>

                </td>

            </tr>

         <?php endforeach; ?>

        </tbody>

    </table>

    <?php DynamicFormWidget::end(); ?>  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
