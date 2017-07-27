<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Cane */

$this->title = 'Create Cane';
$this->params['breadcrumbs'][] = ['label' => 'Canes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cane-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
