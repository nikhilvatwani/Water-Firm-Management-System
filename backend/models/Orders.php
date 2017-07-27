<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $o_id
 * @property integer $c_id
 * @property string $type_id
 * @property string $cane_id
 * @property string $bottle_id
 * @property integer $quantity
 * @property integer $amount
 * @property integer $amount_paid
 * @property integer $amount_pending
 * @property integer $cane_pending
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['c_id', 'type_id', 'quantity', 'amount', 'amount_paid', 'amount_pending'], 'required'],
            [['c_id', 'quantity', 'amount','amount_pending', 'cane_pending'], 'integer'],
            [['type_id', 'cane_id', 'bottle_id','amount_paid'], 'string', 'max' => 30],
            [['created_at','updated_at'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'o_id' => 'Order ID',
            'c_id' => 'Customer Name',
            'type_id' => 'Type',
            'cane_id' => 'Cane Name',
            'bottle_id' => 'Bottle Name',
            'quantity' => 'Quantity',
            'amount' => 'Amount',
            'amount_paid' => 'Amount Paid',
            'amount_pending' => 'Amount Pending',
            'cane_pending' => 'Cane Pending',
        ];
    }
}
