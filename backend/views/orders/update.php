<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

$this->title = 'Update Orders: ' . $model->o_id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->o_id, 'url' => ['view', 'id' => $model->o_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div class="orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
