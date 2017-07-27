<?php

namespace backend\controllers;

use Yii;
use backend\models\Customer;
use backend\models\CustomerSearch;
use backend\models\Rate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Model;
use backend\models\Type;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','delete','logout'],
                        'controllers'=>['customer','rate','reminder','orders','cane','site','bottle'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                //var_dump($dataProvider);
                //die();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $this->viewChangedRate($model);
        //var_dump($model);
        //die();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function viewChangedRate($id){
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
               $price[$key] = $type->type_name."-".$company->name."-".$temp->rate;
           }
            $id->rate = implode(' , ', $price);
            $id->setOldAttribute("rate",$id->rate);
    }
    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();                     
        $modelsRate = [new Rate];
        if ($model->load(Yii::$app->request->post()))
        {

            $modelsRate = Model::createMultiple(Rate::classname());
            Model::loadMultiple($modelsRate, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            //var_dump($valid);
            $valid = Model::validateMultiple($modelsRate) && $valid;
            //var_dump($valid);
            //die();
            $rates = [];
            $i=0;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                        foreach ($modelsRate as $modelRate) {

                            if (! ($flag = $modelRate->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $rates[$i++] = $modelRate->rate_id;
                        }
                    //var_dump($rates);
                    //die();
                        $model->rate = implode(',', $rates);
                    if ($flag) {
                        $model->save();
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->c_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            return $this->redirect(['view', 'id' => $model->c_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsRate' => $modelsRate,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $temp = explode(',',$model->rate);
            $i =0;
            $modelsRate = [];
            foreach ($temp as $key => $value) {
                $modelsRate[$i++] = $this->findModelRate($value);
            }
        if ($model->load(Yii::$app->request->post())) {
            $oldIDs = ArrayHelper::map($modelsRate, 'rate_id', 'rate_id');
            $modelsRate = Model::createMultiple(Rate::classname(),$modelsRate);
            Model::loadMultiple($modelsRate, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsRate, 'rate_id', 'rate_id')));
           // var_dump($modelsRate);
            //die();
            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsRate) && $valid;
            $rates = [];
            $i=0;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                        if (! empty($deletedIDs)) {
                            foreach ($deletedIDs as $key => $value) {
                                $record = Rate::findOne(['rate_id'=>$value]);
                                $record->delete();
                            }
                        }
                        foreach ($modelsRate as $modelRate) {
                         $w = Rate::find()->where(['rate_id' => $modelRate->rate_id ])->exists();
                         if($w){
                           // $record = $this->findModelRate($modelRate['rate_id']);
                            //var_dump($modelRate);
                            //var_dump('-------'.$modelRate->update().'--------');
                            if($modelRate->update()||$modelRate->save()){
                                $flag =1 ;
                            }else{
                                $transaction->rollBack();
                                break;
                            }
                            
                            $rates[$i++] = $modelRate->rate_id;
                         }
                        else{
                            if (! ($flag = $modelRate->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $rates[$i++] = $modelRate->rate_id;
                         }
                        }
                          $model->rate = implode(',', $rates);
                          //var_dump($flag);
                          //die();
                    if ($flag) {
                        $transaction->commit();
                        $model->save();
                        return $this->redirect(['view', 'id' => $model->c_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            return $this->redirect(['view', 'id' => $model->c_id]);
        } else {
            
            return $this->render('update', [
                'model' => $model,
                'modelsRate' => (empty($modelsRate)) ? [new Rate] : $modelsRate
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelRate($id)
    {
        if (($model = Rate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
