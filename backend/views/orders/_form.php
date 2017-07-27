<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Customer;
use backend\models\Type;
use backend\models\Cane;
use backend\models\Bottle;
use yii\helpers\ArrayHelper;
use kartik\touchspin\TouchSpin;
/* @var $this yii\web\View */
/* @var $model backend\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
$(document).ready(function(){
    var temp = Number(document.getElementById("orders-type_id").value);
    switch(temp){
        case 0 : $('.field-orders-cane_id').hide();
                 $('.field-orders-cane_pending').hide();
                 $('.field-orders-bottle_id').hide();
                 break;
        case 1 : $('.field-orders-bottle_id').hide();
                 break;
        case 2 : $('.field-orders-cane_id').hide();
                 $('.field-orders-cane_pending').hide();
                 break;
    } 
});
$(function(){
   $('#orders-type_id').change(function(){
        replacee(this.value); 
    });
   function replacee(value) {
      if(value == 2){
        $('.field-orders-bottle_id').show();
        $('.field-orders-cane_id').hide();
        $('.field-orders-cane_pending').hide();
      }else{
        $('.field-orders-cane_pending').show();
        $('.field-orders-cane_id').show();
        $('.field-orders-bottle_id').hide();
      }
      
  }
  });
   $(function(){
   $('#orders-amount_pending').click(function(){
        //alert("inside click");
        var val1 = document.getElementById("orders-amount").value;
        var val2 = document.getElementById("orders-amount_paid").value;
        if(!isNaN(val1)&&!isNaN(val2)){
                if(Number(val1) >= Number(val2)){
                    document.getElementById("orders-amount_pending").value = val1-val2;
                }
                else{
                    document.getElementById("orders-amount_pending").value = "Amount Paid is greater than amount";
                }
        } 
    });
  }); 
$(function(){
   $('#orders-cane_pending').click(function(){
        //alert("inside click");
        var val3 = document.getElementById("orders-quantity").value;
        console.log(val3);
        if(!isNaN(val3)){
            document.getElementById("orders-cane_pending").value = val3;
        } 
    });
  }); 
</script>
<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $names = ArrayHelper::map(Customer::find()->orderBy('name')->asArray()->all(),'c_id','name');
        $names = array("0" => "Select name") + $names;      
        echo $form->field($model, 'c_id')->dropDownList($names);
     ?>

    <?php 
        $types = ArrayHelper::map(Type::find()->orderBy('type_name')->asArray()->all(),'type_id','type_name');
        $types = array("0" => "Select type") + $types;
        echo $form->field($model, 'type_id')->dropDownList($types);
     ?>

     <?php 
        $canes = ArrayHelper::map(Cane::find()->orderBy('name')->asArray()->all(),'cane_id','name');
        $canes = array("0" => "Select cane") + $canes; 
        echo $form->field($model, 'cane_id')->dropDownList($canes);
     ?>
     <?php 
        $bottles = ArrayHelper::map(Bottle::find()->orderBy('name')->asArray()->all(),'bottle_id','name');
        $quantity = ArrayHelper::map(Bottle::find()->orderBy('name')->asArray()->all(),'bottle_id','quantity');
        foreach ($bottles as $key => $value) {
          $bottles[$key] = $value.'('.$quantity[$key].')';
        }
        $bottles = array("0" => "Select bottle") + $bottles; 
        echo $form->field($model, 'bottle_id')->dropDownList($bottles);
     ?>
    <?= $form->field($model, 'quantity')->widget(TouchSpin::classname(), [
    'pluginOptions' => ['max' => 1000],
]); ?>

    <?= $form->field($model, 'amount')->widget(TouchSpin::classname(), [
    'pluginOptions' => ['max' => 100000],
]); ?>

    <?= $form->field($model, 'amount_paid')->widget(TouchSpin::classname(), [
    'pluginOptions' => ['max' => 100000],
]); ?>

    <?= $form->field($model, 'amount_pending')->textInput() ?>

    <?php 
        echo $form->field($model, 'cane_pending')->textInput(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
