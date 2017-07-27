<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "collection".
 *
 * @property integer $id
 * @property integer $amount
 * @property string $date_time
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'date_time'], 'required'],
            [['amount'], 'integer'],
            [['date_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'date_time' => 'Date Time',
        ];
    }
}
