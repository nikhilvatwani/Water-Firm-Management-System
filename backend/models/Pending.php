<?php
	namespace backend\models;

	use Yii;
	use backend\models\Model;

	class Pending extends Model{
		public $c_id;
		public $amount;

		public function rules()
		    {
		        return [
		            [['c_id','amount'], 'required'],
		            [['amount'], 'integer'],
		        ];
		    }
		}
?>