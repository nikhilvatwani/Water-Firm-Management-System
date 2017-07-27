<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Orders;
use backend\models\Customer;
use backend\models\Type;
use backend\models\Cane;
use backend\models\Bottle;

/**
 * OrdersSearch represents the model behind the search form about `backend\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['o_id', 'c_id', 'quantity', 'amount', 'amount_paid', 'amount_pending', 'cane_pending'], 'integer'],
            [['type_id', 'cane_id', 'bottle_id'], 'safe'],
            [['created_at','updated_at'],'safe'],
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
        $query = Orders::find();

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
            'o_id' => $this->o_id,
            'c_id' => $this->c_id,
            'quantity' => $this->quantity,
            'amount' => $this->amount,
            'amount_paid' => $this->amount_paid,
            'amount_pending' => $this->amount_pending,
            'cane_pending' => $this->cane_pending,
        ]);

        $query->andFilterWhere(['like', 'type_id', $this->type_id])
            ->andFilterWhere(['like', 'cane_id', $this->cane_id])
            ->andFilterWhere(['like', 'bottle_id', $this->bottle_id]);

        $this->changeView($dataProvider->getModels());

        return $dataProvider;
    }

    public function changeView($ids){

        foreach ($ids as $id) {
            //var_dump($id);
           //die();
           $customer = Customer::findOne(['c_id'=>$id->c_id]);
           //var_dump($customer);
           //die();
           $id->c_id = $customer->name;
           $id->setOldAttribute("c_id",$id->c_id);
           $type = Type::findOne(['type_id'=>$id->type_id]);
           $id->type_id = $type->type_name;
           $id->setOldAttribute("type_id",$id->type_id);
           $name = ucwords($type->type_name);
           $name = "backend\models\\".$name;
            $company_name = $type->type_name.'_id';
           if($name::find()->where([$type->type_name.'_id' => $id[$company_name]])->exists()){
             $company = $name::findOne([$type->type_name.'_id' => $id[$company_name]]);
              if($type->type_name=="bottle")
                $company->name = $company->name."(".$company->quantity.")";
             $id[$company_name] = $company->name;
            }else{
                $id[$company_name] = 'Not Available';
            }
           //var_dump($id[$company_name]);
           //die();
        }
        //die();
    }
}
