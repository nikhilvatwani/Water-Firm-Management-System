<?php
	namespace backend\models;

	use Yii;
	use yii\base\Model;

	class Temp extends Model{
		public $name;
		public $stock;
		public $quantity;
		public $type;
 		public function rules(){
			return [
				[['name','stock','type'],'required'],
				[['stock'], 'integer'],
            	[['name'], 'string', 'max' => 30],
            	[['quantity'], 'string', 'max' => 20],
			];
		}
	}

?>