<?php
	namespace backend\views;

	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use backend\models\Type;
	use yii\db\Query;
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
$(function(){
   $('#temp-type').change(function(){
        replacee(this.value); 
    });
   function replacee(value) {

      if(value == 2){
        $('.field-temp-quantity').show();
      }else{
      	$('.field-temp-quantity').hide();
      }
      
  }
  });

</script>

<?php $form = ActiveForm::begin(); ?>
	
	<?php 
			$query = Type::find();
			$types =$query->orderBy('type_name')->asArray()->all();
			$arr = [];
			foreach($types as $type){
				$arr[intval($type['type_id'])]=$type['type_name'];
				//var_dump(intval($type['type_id']));
			}
			//var_dump($arr);
			//die();
	?>

	<?= $form->field($model,'type')->dropDownList($arr) ?>

	<?= $form->field($model,'name')->textInput(['maxlength' => true]) ?>

	<?php
		$quantity = ["200ml"=>"200ml","500ml"=>"500ml","1ltr"=>"1ltr"];
	 	echo $form->field($model,'quantity')->dropDownList($quantity) ?>

	<?= $form->field($model,'stock')->textInput() ?>

	<div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>