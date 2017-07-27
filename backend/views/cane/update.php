<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cane */

$this->title = 'Update Cane: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Canes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->cane_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div class="cane-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
