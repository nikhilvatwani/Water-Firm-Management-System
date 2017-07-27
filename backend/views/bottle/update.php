<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Bottle */

$this->title = 'Update Bottle: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bottles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->bottle_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bottle-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('//cane/caneplusbottle', [
        'model' => $model,
    ]) ?>

</div>
