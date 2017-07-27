<?php

namespace backend\controllers;

use Yii;
use backend\models\Cane;
use backend\models\Bottle;
use backend\models\CaneSearch;
use backend\models\BottleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Temp;
use yii\filters\AccessControl;
/**
 * MainController implements the CRUD actions for Cane model.
 */
class CaneController extends Controller
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
                        'actions' => ['index','view','create','update','delete'],
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
     * Lists all Cane models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CaneSearch();
            $searchModelBottle = new BottleSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderBottle = $searchModelBottle->search(Yii::$app->request->queryParams);
            return $this->render('caneplusbottle_view',['searchModel'=>$searchModel,'dataProvider'=>$dataProvider,'searchModelBottle'=>$searchModelBottle,'dataProviderBottle'=>$dataProviderBottle]);
    }

    /**
     * Displays a single Cane model.
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
     * Creates a new Cane model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $model = new Temp;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            switch($model->type){
                case 1:
                    $model_new = new Cane;
                    $model_new->name =  $model->name;
                    $model_new->stock = intval($model->stock);
                break;
                case 2: 
                    $model_new = new Bottle;
                    $model_new->name =  $model->name;
                    $model_new->stock = intval($model->stock);
                    $model_new->quantity = $model->quantity;
                break;
            }
            $model_new->save();
            $searchModel = new CaneSearch();
            $searchModelBottle = new BottleSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderBottle = $searchModelBottle->search(Yii::$app->request->queryParams);
            return $this->render('caneplusbottle_view',['searchModel'=>$searchModel,'dataProvider'=>$dataProvider,'searchModelBottle'=>$searchModelBottle,'dataProviderBottle'=>$dataProviderBottle]);
        }else{
            return $this->render('caneplusbottle',['model'=>$model]);
        }
    }

    public function actionTemp(){

        $model = new Temp;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            switch($model->type){
                case 1:
                    $model_new = new Cane;
                    $model_new->name =  $model->name;
                    $model_new->stock = intval($model->stock);
                break;
                case 2: 
                    $model_new = new Bottle;
                    $model_new->name =  $model->name;
                    $model_new->stock = intval($model->stock);
                    $model_new->quantity = $model->quantity;
                break;
            }
            $model_new->save();
            $searchModel = new CaneSearch();
            $searchModelBottle = new BottleSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderBottle = $searchModelBottle->search(Yii::$app->request->queryParams);
            return $this->render('caneplusbottle_view',['searchModel'=>$searchModel,'dataProvider'=>$dataProvider,'searchModelBottle'=>$searchModelBottle,'dataProviderBottle'=>$dataProviderBottle]);
        }else{
            return $this->render('caneplusbottle',['model'=>$model]);
        }
    }
    public function actionA(){
        $searchModel = new CaneSearch();
            $searchModelBottle = new BottleSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProviderBottle = $searchModelBottle->search(Yii::$app->request->queryParams);
            return $this->render('caneplusbottle_view',['searchModel'=>$searchModel,'dataProvider'=>$dataProvider,'searchModelBottle'=>$searchModelBottle,'dataProviderBottle'=>$dataProviderBottle]);
    }
    /**
     * Updates an existing Cane model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cane_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cane model.
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
     * Finds the Cane model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cane the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cane::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
