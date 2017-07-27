<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "expense".
 *
 * @property integer $id
 * @property string $what
 * @property integer $amount
 * @property string $created_at
 */
class Expense extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expense';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['what', 'amount'], 'required'],
            [['amount'], 'integer'],
            [['created_at'], 'safe'],
            [['what'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'what' => 'What',
            'amount' => 'Amount',
            'created_at' => 'Created At',
        ];
    }
}
