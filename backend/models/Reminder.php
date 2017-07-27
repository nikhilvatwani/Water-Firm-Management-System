<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "reminder".
 *
 * @property integer $id
 * @property string $what
 * @property string $place
 * @property string $dateandtime
 */
class Reminder extends \yii\db\ActiveRecord
{
    public $start_date;
    public $end_date;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reminder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['what', 'place', 'dateandtime'], 'required'],
            [['dateandtime'], 'safe'],
            [['what', 'place'], 'string', 'max' => 70],
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
            'place' => 'Place',
            'dateandtime' => 'Date',
        ];
    }
}
