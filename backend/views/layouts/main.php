<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Krishna Enterprises',
        'brandUrl' => 'http://nikhilvatwani-001-site1.1tempurl.com/advanced_old/backend/web/index.php?r=reminder/index',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/reminder/index']],
        [
            'label' => 'Customers',
            'items' => [
                 ['label' => 'Create', 'url' => '/advanced_old/backend/web/index.php?r=customer/create'],
                 '<li class="divider"></li>',
                 ['label' => 'View,update,Delete', 'url' => '/advanced_old/backend/web/index.php?r=customer/index'],
            ],
        ],
        [
            'label' => 'Orders',
            'items' => [
                 ['label' => 'Create', 'url' => '/advanced_old/backend/web/index.php?r=orders/create'],
                 '<li class="divider"></li>',
                 ['label' => 'View,update,Delete', 'url' => '/advanced_old/backend/web/index.php?r=orders/index'],
            ],
        ],
        [
            'label' => 'Stock',
            'items' => [
                 ['label' => 'Create', 'url' => '/advanced_old/backend/web/index.php?r=cane/create'],
                 '<li class="divider"></li>',
                 ['label' => 'View,update,Delete', 'url' => '/advanced_old/backend/web/index.php?r=cane/index'],
            ],
        ],
        [
            'label' => 'Expenses',
            'items' => [
                 ['label' => 'Create', 'url' => '/advanced_old/backend/web/index.php?r=expense/create'],
                 '<li class="divider"></li>',
                 ['label' => 'View,update,Delete', 'url' => '/advanced_old/backend/web/index.php?r=expense/index'],
            ],
        ],
        [
            'label' => 'Pending',
            'items' => [
                 ['label' => 'Amount', 'url' => '/advanced_old/backend/web/index.php?r=orders/pending'],
                 '<li class="divider"></li>',
                 ['label' => 'Cane', 'url' => '/advanced_old/backend/web/index.php?r=orders/pendingcane'],
            ],
        ],
        ['label' => 'Add Reminder', 'url' => ['/reminder/create']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
