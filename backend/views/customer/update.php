<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */

$this->title = 'Update Customer: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->c_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div class="customer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsRate'=>$modelsRate,
    ]) ?>

</div>
