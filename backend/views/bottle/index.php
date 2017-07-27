<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BottleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bottle-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bottle', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bottle_id',
            'name',
            'stock',
            'quantity',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','/advanced_old/backend/web/index.php?r=bottle%2Fview&id='.$model->bottle_id);
                    },
                    'update' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>','/advanced_old/backend/web/index.php?r=bottle%2Fupdate&id='.$model->bottle_id);
                    },
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>','/advanced_old/backend/web/index.php?r=bottle%2Fdelete&id='.$model->bottle_id);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
