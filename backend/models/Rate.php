<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rate".
 *
 * @property integer $rate_id
 * @property integer $type
 * @property integer $company
 * @property integer $rate
 */
class Rate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'company', 'rate'], 'required'],
            [['type', 'company', 'rate'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rate_id' => 'Rate ID',
            'type' => 'Type',
            'company' => 'Company',
            'rate' => 'Rate',
        ];
    }
}
