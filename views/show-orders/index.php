<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShowOrders */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders Bases');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-base-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Orders Base'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php try {
         echo GridView::widget([
            'dataProvider' => $dataProvider,
            //        'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //            'id',
                //            'client_id',
//                'name',
                'orderNumCRM',
                //            'clientIdCrm',
                //'email:email',
                //'phone',
                'comment:ntext',
                'status',
                'totalPrice',
                //            'eventtime',

                ['class' => 'yii\grid\ActionColumn'],

            ],
        ]);
    } catch (Exception $e) {
    } ?>


</div>
