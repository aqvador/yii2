<?php
/**
 * @var $model app\controllers\auth\authSignUpActions
 */
?>

<div class="row">
    <div class="col-md-6">
        <?php $form = \yii\bootstrap\ActiveForm::begin()?>

        <?=$form->field($model, 'email')?>
        <?=$form->field($model, 'password')->passwordInput()?>

        <?=\yii\bootstrap\Html::submitButton(['Регистрация'], ['class' => 'btn btn-primary'])?>
        <?php  \yii\bootstrap\ActiveForm::end()?>
    </div>
</div>
