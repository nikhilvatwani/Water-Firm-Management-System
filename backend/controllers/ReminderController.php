<?php

namespace backend\controllers;

use Yii;
use backend\models\Reminder;
use backend\models\ReminderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Collection;
use backend\models\Customer;
/**
 * ReminderController implements the CRUD actions for Reminder model.
 */
class ReminderController extends Controller
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
                        'actions' => ['index','view','create','update','delete','amount','del'],
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
     * Lists all Reminder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Reminder;
        $searchModel = new ReminderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model'=>$model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reminder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Reminder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reminder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Reminder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
                    //var_dump($model->dateandtime);
                    //die();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Reminder model.
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
     * Finds the Reminder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reminder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reminder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDel($data){
        $del = Reminder::findOne(['id'=>$data])->delete();
    }
    public function actionAmount($start,$end){
        date_default_timezone_set('Asia/Kolkata');
        $d=strtotime($start);
        $e=strtotime($end);
        $d=date("Y-m-d H:i:00", $d);
        $e=date("Y-m-d H:i:00", $e);
        $data = Collection::find()->where(['>=','date_time',$d])->andWhere(['<=','date_time',$e])->asArray()->all();
       // var_dump($d);
        //var_dump($e);
        foreach ($data as $key => $value) {
            $name = Customer::findOne(['c_id'=>$value['name']]);
            $data[$key]['name'] = $name->name; 
        }
        return json_encode($data);
    }
}
