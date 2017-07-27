<?php

namespace backend\controllers;

use Yii;
use backend\models\Orders;
use backend\models\OrdersSearch;
use backend\models\Cane;
use backend\models\Bottle;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Customer;
use backend\models\Type;
use yii\filters\AccessControl;
use backend\models\Collection;
use backend\models\Pending;
/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
                        'actions' => ['index','view','create','update','delete','pending','clearamount','pendingcane','clearcane'],
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
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
        public function changeView($id){
            //var_dump($id);
           //die();
           $customer = Customer::findOne(['c_id'=>$id->c_id]);
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
        //die();
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        //var_dump($model);
        //die();
       $this->changeView($model);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post())) {
            //var_dump($model->type_id);
           //die();
            $model_collection = new Collection;
            $model_collection->amount = $model->amount_paid;
            date_default_timezone_set('Asia/Kolkata');
            $model_collection->date_time = date('Y-m-d H:i');
            $model_collection->name= $model->c_id;
            if($model->type_id == "1"){
                $model->bottle_id = "0";
                $ordered = Cane::findOne($model->cane_id);
                //var_dump($ordered->stock);
                //die();      
                $ordered->stock -= (int)$model->quantity;
            }else if($model->type_id == "2"){
                $model->cane_id = "0";
                $model->cane_pending = "0";
                $ordered = Bottle::findOne($model->bottle_id);
                $ordered->stock -= (int)$model->quantity;
            }
            date_default_timezone_set('Asia/Kolkata');
            $model->created_at = date('Y-m-d H-i');
            $model->save();
            $model_collection->save();
            $ordered->update();
            return $this->redirect(['view', 'id' => $model->o_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('Asia/Kolkata');
            $model->updated_at = date('Y-m-d H-i');
            $model->save();
            return $this->redirect(['view', 'id' => $model->o_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Orders model.
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
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPending(){
        $model = new Pending;
        $arr = Orders::find()->where(['<>','amount_pending',0])->asArray()->all();
        //var_dump($arr);
        //die();
            return $this->render('pending_amount', [
                                 'model' => $model,
                                 'arr'=>$arr
            ]);
    }

    public function actionClearamount($orderid,$value){
        $new_model = new Collection;
        $model = $this->findModel($orderid);
        $model->amount_pending -= $value;
        $model->amount_paid = $model->amount_paid.",".$value;
        date_default_timezone_set('Asia/Kolkata');
        $model->updated_at = date('Y-m-d H-i');
        $model->update();
       // var_dump($model->amount_paid.",".$value);
        $new_model->amount = $value;
        date_default_timezone_set('Asia/Kolkata');
        $new_model->date_time = date('Y-m-d H:i');
        $new_model->name = $model->c_id;
        $new_model->save();
        return json_encode('hi');
    }

    public function actionPendingcane(){
        $model = new Pending;
        $arr = Orders::find()->where(['<>','cane_pending',0])->asArray()->all();
        //var_dump($arr);
        //die();
            return $this->render('pending_cane', [
                                 'model' => $model,
                                 'arr'=>$arr
            ]);
    }

    public function actionClearcane($orderid,$value){
        $model = $this->findModel($orderid);
        $model->cane_pending -= $value;
        date_default_timezone_set('Asia/Kolkata');
        $model->updated_at = date('Y-m-d H-i');
        $model->update();
        return json_encode('hi');
    }
}
