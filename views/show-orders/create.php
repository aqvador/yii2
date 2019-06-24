<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrdersBase */

$this->title = Yii::t('app', 'Create Orders Base');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders Bases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-base-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
