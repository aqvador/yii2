<?php
/**
 * @var $model app\controllers\auth\authSignInActions
 */
?>

<div class="row">
    <div class="col-md-6">
        <?php $form = \yii\bootstrap\ActiveForm::begin() ?>

		<?= $form->field($model, 'email')->widget(\yii\widgets\MaskedInput::class, [
            'name' => 'input-36',
            'clientOptions' => [
                'alias' => 'email'
            ]
        ])->textInput(['placeholder' => 'name@exemple.ru'])->label('Ваш email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= \yii\bootstrap\Html::submitInput('Авторизация', ['class' => 'btn btn-primary']) ?>
        <?php \yii\bootstrap\ActiveForm::end() ?>
    </div>
</div>
