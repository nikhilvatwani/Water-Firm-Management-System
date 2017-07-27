<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

class Model extends \yii\base\Model
{
    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        //var_dump($multipleModels);
        //die();
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];
        //var_dump($post);
       // die();
        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'rate_id', 'rate_id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['rate_id']) && !empty($item['rate_id']) && isset($multipleModels[$item['rate_id']])) {
                    $models[] = $multipleModels[$item['rate_id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }
}
