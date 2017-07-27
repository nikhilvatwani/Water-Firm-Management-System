<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Alert;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use backend\models\Collection;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReminderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reminders';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
    function giveAmount(){
        $('.collectiontable').empty();
        var start = $('#reminder-start_date').val();
        console.log(typeof start);
        var end = $('#reminder-end_date').val();
        console.log(typeof end);
        if(start != '' && end != '')
        {      $.ajax({
               url : 'http://localhost/advanced_old/backend/web/index.php?r=reminder/amount&start='+start+'&end='+end,
               dataType: "json",
               success: function(data){
                   //console.log(data);
                   var obj = eval(data);
                   //console.log(obj[0]);
                   var sum = 0;
                   $('.collectiontable').append('<thead><th>Name</th><th>Amount Paid</th><th>Time</th></thead><tbody id="unique">');
                               $(obj).each(function(key,value){
                                   $('#unique').append('<tr><td>'+value['name']+'</td><td>'+value['amount']+'</td><td>'+value['date_time']+'</td></tr>');
                                   var temp = parseInt(value['amount']);
                                   sum = sum + temp;
                                  // console.log(sum);
                               });
                   $('.collectiontable').append('</tbody>');
                   $('#total-amount').html(sum);
               }
           })
        }
    }
</script>
<div class="reminder-index">

<div class="row">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4">
        <?= $form->field($model,'start_date')->widget(DateTimePicker::className(), [ 'name' => 'datetime_10',
                                                                                    'options' => ['placeholder' => 'Select operating time ...'],
                                                                                    'convertFormat' => true,
                                                                                    'pluginOptions' => [
                                                                                        'todayHighlight' => true]]);
        ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model,'end_date')->widget(DateTimePicker::className(), [ 'name' => 'datetime_10',
                                                                                'options' => ['placeholder' => 'Select operating time ...'],
                                                                                'convertFormat' => true,
                                                                                'pluginOptions' => [
                                                                                    'todayHighlight' => true]])
         ?>
    </div>
     <?php ActiveForm::end(); ?>
         <div class="col-md-4 btn btn-success" onclick="giveAmount()" style="margin-top:2%">Hit It</div>
</div>
<div class="row">
        <table class="table col-md-12 collectiontable">
        </table>
</div>
<div class="row">
    <div class="col-md-1"><h4>Collection:</h4></div>
    <div class="col-md-1"><h4 id="total-amount"></h4></div>
</div>
<?php
        date_default_timezone_set('Asia/Kolkata');
     $start = date('Y-m-d 00-00-00'); 
      $current = date('Y-m-d H-i-s');
?>
<div class="row">
    <div class="col-md-5"><h3>Today's Collection : <?php echo Collection::find()->where(['>=','date_time',$start])->andWhere(['<=','date_time',$current])->sum('amount') ?></h3></div>
</div>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $data = $dataProvider->getModels();
    foreach ($data as $key => $value) {
        //$temp = $value->id;
         $message = 'Deliver <strong>'.$value->what.'</strong> at <strong>'.$value->place.'</strong> on <strong>'.$value->dateandtime.'</strong>';
    ?>
             <div class="alert alert-success">
              <a href="#" class="close" aria-label="close" onclick="tp(<?php echo $value->id?>,this)">&times;</a>
              <?php echo $message ?>
            </div>
    <?php
    }
    ?>
    <script>
    function tp(temp,ref){
        var c = confirm('Are you sure you want to delete');
        if(c==true){
            $(ref).attr("data-dismiss","alert");
            $.ajax({
                url :'http://nikhilvatwani-001-site1.1tempurl.com/advanced_old/backend/web/index.php?r=reminder/del&data='+temp,
                dataType: "json",
            });
        }
    }
    </script>
</div>
