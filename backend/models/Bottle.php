<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bottle".
 *
 * @property integer $bottle_id
 * @property string $name
 * @property integer $stock
 * @property string $quantity
 */
class Bottle extends \yii\db\ActiveRecord
{
    public $type = '2';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bottle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'stock', 'quantity'], 'required'],
            [['stock'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['quantity'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bottle_id' => 'Bottle ID',
            'name' => 'Name',
            'stock' => 'Stock',
            'quantity' => 'Quantity',
        ];
    }
}
