<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cane".
 *
 * @property integer $cane_id
 * @property string $name
 * @property integer $stock
 */
class Cane extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cane';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'stock'], 'required'],
            [['stock'], 'integer'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cane_id' => 'Cane ID',
            'name' => 'Name',
            'stock' => 'Stock',
        ];
    }
}
