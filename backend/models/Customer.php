<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $c_id
 * @property string $name
 * @property string $contact_no
 * @property string $address
 * @property string $rate
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['contact_no'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 100],
            [['rate'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'c_id' => 'C ID',
            'name' => 'Name',
            'contact_no' => 'Contact No',
            'address' => 'Address',
            'rate' => 'Rate',
        ];
    }
}
