<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Reminder */

$this->title = 'Update Reminder: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reminders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div class="reminder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
