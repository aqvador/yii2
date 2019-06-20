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
	<title><?= Html::encode((isset($this->params['title']))?$this->params['title']:'Задайте title странице') ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php
    NavBar::begin([
        'brandLabel' => 'Brand',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-inverse navbar-fixed-top',],
    ]);
    $nav['options'] = ['class' => 'navbar-nav navbar-right'];
    $nav['items'] = [
        ['label' => 'Загрузка фото', 'url' => ['/uploadphoto/index']],
        ['label' => 'Домой', 'url' => ['/site/index']],
        ['label' => 'О нас', 'url' => ['/site/about']],
        ['label' => 'Форма', 'url' => ['/activity/create']],
        Yii::$app->user->isGuest ? ([
            'label' => 'Войти',
            'url' => ['/auth/sign-in']
        ]) : ('<li>' . Html::beginForm(['/auth/log-out'], 'post') . Html::submitButton('Выйти (' . Yii::$app->user->identity->name . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>')
    ];
    #Если есть последняя посещенная страница упользователя, то добавим ее в конец меню
    echo Nav::widget($nav);
    NavBar::end();
    ?>

	<div class="container">
        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) ?>
        <?= Alert::widget() ?>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Brand <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>