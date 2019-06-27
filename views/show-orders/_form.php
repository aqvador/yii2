<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrdersBase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-base-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'client_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orderNumCRM')->textInput() ?>

    <?= $form->field($model, 'clientIdCrm')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'open' => 'Open', 'job' => 'Job', 'close' => 'Close', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'totalPrice')->textInput() ?>

    <?= $form->field($model, 'eventtime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
