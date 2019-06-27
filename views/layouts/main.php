<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?php $this->registerCsrfMetaTags() ?>
	<title><?= Html::encode((isset($this->params['title'])) ? $this->params['title'] : 'Задайте title странице') ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php
    NavBar::begin([
        'brandLabel' => 'pic66',
        'brandUrl' => Yii::$app->homeUrl,
        //        'brandImage' => '@web/logo.png',
        'options' => ['class' => 'navbar-inverse navbar-fixed-top',],
    ]);
    $nav['options'] = ['class' => 'navbar-nav navbar-right'];
    $nav['items'] = [
        ['label' => 'Загрузка фото', 'url' => ['/uploadphoto/index']],
        ['label' => 'Заказы', 'url' => ['/show-orders/index'], 'visible' => !Yii::$app->user->isGuest],
        Yii::$app->user->isGuest ? ([
            'label' => 'Войти',
            'url' => ['/auth/sign-in']
        ]) : ([
            'label' => 'Выйти (' . Yii::$app->user->identity->name . ')',
            'url' => ['/auth/log-out']
        ]),
        Yii::$app->user->isGuest ? ([
            'label' => 'Регистрация',
            'url' => ['/auth/sign-up']
        ]) : ''
    ];
    echo Nav::widget($nav);
    NavBar::end();
    ?>

	<div class="container">
        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
        <?= Alert::widget() ?>

        <?= $content ?>
    </div>

</div>

<?= $this->render('footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>




