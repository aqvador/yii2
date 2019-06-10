<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin(['brandLabel' => Yii::$app->name, 'brandUrl' => Yii::$app->homeUrl, 'options' => ['class' => 'navbar-inverse navbar-fixed-top',],]);
    $nav['options'] = ['class' => 'navbar-nav navbar-right'];
    $nav['items'] = [['label' => 'Домой', 'url' => ['/site/index']], ['label' => 'О нас', 'url' => ['/site/about']], ['label' => 'Контакты', 'url' => ['/site/contact']], Yii::$app->user->isGuest ? (['label' => 'Войти', 'url' => ['/site/login']]) : ('<li>' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Выйти (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']) . Html::endForm() . '</li>')];
    #Если есть последняя посещенная страница упользователя, то добавим ее в конец меню
    if (!empty(\Yii::$app->session->get('page')))
        $nav['items'][] = ['label' => 'Предыдущая', 'url' => ['/' . \Yii::$app->session->get('page')]];
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
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php \Yii::$app->session->set('page', Yii::$app->request->getPathInfo()) ?>
