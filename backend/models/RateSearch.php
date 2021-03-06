<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Rate;

/**
 * RateSearch represents the model behind the search form about `backend\models\Rate`.
 */
class RateSearch extends Rate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rate_id', 'type', 'company', 'rate'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Rate::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'rate_id' => $this->rate_id,
            'type' => $this->type,
            'company' => $this->company,
            'rate' => $this->rate,
        ]);

        return $dataProvider;
    }
}
