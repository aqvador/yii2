<?php
/**
 * @var $model app\controllers\auth\authSignUpActions
 */
?>

<div class="row">
    <div class="col-md-6">
        <?php $form = \yii\bootstrap\ActiveForm::begin() ?>
        <?= $form->field($model, 'name')?>

		<?= $form->field($model, 'email')->widget(\yii\widgets\MaskedInput::class, [
            'name' => 'input-36',
            'clientOptions' => [
                'alias' => 'email'
            ]
        ])->textInput(['placeholder' => 'name@exemple.ru'])->label('Ваш email') ?>
		<?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, ['mask' => '+7 (999) 999-99-99'])->textInput(['placeholder' => '+7 (999) 999-99-99'])->label('Ваш телефон'); ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'confirmPass')->passwordInput() ?>

        <?= \yii\bootstrap\Html::submitInput('Регистрация', ['class' => 'btn btn-primary']) ?>
        <?php \yii\bootstrap\ActiveForm::end() ?>
    </div>
</div>
