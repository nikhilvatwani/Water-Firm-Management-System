<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Rate */

$this->title = 'Update Rate: ' . $model->rate_id;
$this->params['breadcrumbs'][] = ['label' => 'Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rate_id, 'url' => ['view', 'id' => $model->rate_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
