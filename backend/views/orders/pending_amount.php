<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Customer;
use backend\models\Type;
use kartik\popover\PopoverX;
/* @var $this yii\web\View */
/* @var $model backend\models\Bottle */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
    function clearAmount(ref,orderid,pending){

        var value = $(ref).parent().parent().find('.usr').val();
        var error = $(ref).parent().parent().find('.err');
        if(!isNaN(value)){
            if(value<=pending){
                $.ajax({
                    url : 'http://localhost/advanced_old/backend/web/index.php?r=orders/clearamount&orderid='+orderid+'&value='+value,
                    dataType: "json",
                    success:function(data){
                        var flash = $(ref).parent().parent().find('.popover-title').find('.close');
                        $(flash).after('<p style="color:red;font-weight:bold">Refresh the page to see the changes</p>')

                    }
                })

            }else{
                $(error).html('entered amount is greater than pending');
            }

        }else{
            $(error).html('enter valid amount');
        }

    }
    function temp(ref){
        $(ref).parent().next('.err').empty();
    }
</script>

<div class="pending-amount-form">
        <table class="table table-hover">
        <thead>
             <tr>
                <th>name</th>
                <th>quantity</th>
                <th>company</th>
                <th>type</th>
                <th>Pending Amount</th>
                <th>Clear Pending</th>
             </tr>
        </thead>
        <tbody>

    <?php
        foreach ($arr as $key => $value) {
            $customer = Customer::findOne(['c_id'=>$value['c_id']]);
            $customer = $customer['name'];
            $type = Type::findOne(['type_id'=>$value['type_id']]);
            //$type = $type['type_name'];
            $name = ucwords($type['type_name']);
           $name = "backend\models\\".$name;
           $company_name = $type['type_name'].'_id';
           $company = $name::findOne([$type->type_name.'_id' => $value[$company_name]]);
            if($type->type_name=="bottle")
                  $company['name'] = $company['name']."(".$company['quantity'].")";
           $company = $company['name'];

    ?>
        <tr>
            <td><?= $customer ?></td>
            <td><?= $value['quantity'] ?></td>
            <td><?= $company ?></td>
            <td><?= $type['type_name'] ?></td>
            <td><?= $value['amount_pending'] ?></td>
            <td><?php $content = '<div class="form-group">
                                  <label for="usr">Amount Paid : </label>
                                  <input type="text" class="form-control usr" onfocus="temp(this)">
                                </div><p style="color:red" class="err"></p>';
    
// right
echo PopoverX::widget([
    'header' => '',
    'placement' => PopoverX::ALIGN_LEFT,
    'content' => $content,
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary','id'=>'unique-'.$value['o_id'],'onclick'=>'clearAmount(this,'.$value['o_id'].','.$value['amount_pending'].')']),
    'toggleButton' => ['label'=>'Clear', 'class'=>'btn btn-default'],
]); ?></td>
          </tr>


    <?php
        }
    ?>
        </tbody>
    </table>

</div>
