<?php

namespace backend\controllers;

use Yii;
use backend\models\Rate;
use backend\models\Cane;
use backend\models\Bottle;
use backend\models\RateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Model;
use yii\filters\AccessControl;
//use yii\web\Response;
//use yii\base\Model;
/**
 * RateController implements the CRUD actions for Rate model.
 */
class RateController extends Controller
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
                        'actions' => ['index','view','create','update','delete','temp'],
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
     * Lists all Rate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rate model.
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
     * Creates a new Rate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rate();
        $modelsRate = [new Rate];
        if ( $model->load(Yii::$app->request->post())  && $model->save()) {
            echo "inside";
            $modelsRate = Model::createMultiple(Rate::classname());
            Model::loadMultiple($modelsRate, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            var_dump($valid);
            $valid = Model::validateMultiple($modelsRate) && $valid;
            var_dump($valid);
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsRate as $modelRate) {
                            //$modelPoItem->po_id = $model->id;
                            if (! ($flag = $modelRate->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->rate_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            echo " here";
        } else {
            return $this->render('create', [
                'model'=>$model,
                'modelsRate' => $modelsRate,
            ]);
        }
    }

    /**
     * Updates an existing Rate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rate_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Rate model.
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
     * Finds the Rate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTemp($type){
        switch(intval($type)){
            case 1 : $data = Cane::find()->orderBy('name')->asArray()->all();
                    break;
            case 2 : $data = Bottle::find()->orderBy('name')->asArray()->all();
                     break;
        }
        return json_encode($data);
        //var_dump($data);
        //die();
    }
}
