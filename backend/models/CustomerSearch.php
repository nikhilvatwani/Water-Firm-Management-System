<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Customer;
use backend\models\Type;
//use backend\models\Bottle;
/**
 * CustomerSearch represents the model behind the search form about `backend\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public $temp = [];

    public function rules()
    {
        return [
            [['c_id', 'contact_no'], 'integer'],
            [['name', 'address', 'rate'], 'safe'],
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
        $query = Customer::find();

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
            'c_id' => $this->c_id,
            'contact_no' => $this->contact_no,
        ]);

        //$temp = $this->changeRate();

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'rate', $this->rate]);
       $this->changeRate($dataProvider->getModels());
       //var_dump($dataProvider->getModels());
       //die();
        return $dataProvider;
    }

     public function changeRate($ids){

        foreach ($ids as $id) {
            //var_dump($id);
           // die();
           $t = [];
           $price = [];
           $t = explode(',', $id['rate']);
           foreach ($t as $key => $value) {
               $temp = Rate::findOne(['rate_id'=>$value]);
               $type = Type::findOne(['type_id'=>$temp->type]);
               $name = ucwords($type->type_name);
               //var_dump($name);
               //die();
               $name = "backend\models\\".$name;  
              if($name::find()->where([$type->type_name.'_id' => $temp->company])->exists()){
                 $company = $name::findOne([$type->type_name.'_id' => $temp->company]);
                 if($type->type_name=="bottle")
                    $company->name = $company->name."(".$company->quantity.")";
                }else{
                  $company['name'] = 'Not Available';
                 }
               $price[$key] = $type->type_name."-".$company['name']."-".$temp->rate;
           }
          $id->rate = implode(' , ', $price);
          $id->setOldAttribute("rate",$id->rate);
        }
        //die();
           
     }
}
