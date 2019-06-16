<?php
/**
 * @var $model \app\models\uploadphoto\StartUploadPhoto
 * @var $size \app\controllers\UploadphotoController
 */

use \yii\bootstrap\ActiveForm;
use \yii\bootstrap\Html;


?>
	<div class="content">
        <div class="moduletable ">
            <h3 id="photoprint_order" data-mid="116" onclick="showPhotoprintForm();"
				class="button_glow"> Приступить к оформлению заказа</h3>
            <div id="loading"><img src="/img/uploadphoto/loading.gif"/>
            </div>
            <div class="order_form">
                <h3 style="color: #0086c0; margin-bottom: 0;">Номер заказа: <span
							id="order_num"></span></h3>
                <h3 style="color: #0086c0;">К оплате: <span style="color: #d7582d;"
															id="order_price"></span></h3>
                <div id="extended_products"
					 onclick="jQuery('#recomended_products').modal();"></div>
                <?php $form = ActiveForm::begin([
                    'id' => 'OrderFormPhoto',
                ]) ?>
                <?= $form->field($model, 'name')->textInput()->label('Имя'); ?>
                <?= $form->field($model, 'email')->widget(\yii\widgets\MaskedInput::className(), [
                    'name' => 'input-36',
                    'clientOptions' => [
                        'alias' => 'email'
                    ]
                ])->textInput(['placeholder' => 'name@exemple.ru'])->label('Ваш email') ?>
                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+7 (999) 999-99-99'])->textInput(['placeholder' => '+7 (999) 999-99-99'])->label('Ваш телефон'); ?>
                <?= $form->field($model, 'comment')->textarea()->label('Комментарий') ?>
                <?= Html::submitInput('Подтвердить заказ'); ?>
                <?php $form = ActiveForm::end() ?>
				<input class="cancel_order" onclick="hideOrderForm();" type="button"
					   value="Назад">
            </div>
            <div id="photoprint_form">
                <div id="sizes">
                    <div
							style="border: 1px solid #0086c0; text-align: center; font-weight: bold; color: #0086c0; padding: 0.5rem;">
                        Выберите размер:
                    </div>
                    <?php
                    foreach ($size as $k => $v):
                        $param[$v['size']] = $v['price']; ?>

                        <?= $form = Html::a($v['size'], ['#'], ['class' => ($v['chosen'] == 1) ? 'chosen' : '']); ?>
						<div class="size_cnt" title="Количество загруженных фотографий">0</div>
                    <?php endforeach; ?>

                </div>
                <div id="upload_block">
                    <?php foreach ($size as $k => $v): ?>
                        <?= Yii::$app->controller->renderPartial('upload', ['item' => $v]); ?>
                    <?php endforeach; ?>
                </div>
                <hr style="clear: both; margin-top: 0; padding-top: 1.2rem;"/>
            </div>
            <div id="photoprint_price">
                <div>Стоимость: <span id="price">0</span> руб.</div>
                <div>
                    <input onclick="showOrderForm();" type="button" value="Оформить заказ"/>
                </div>
                <div class="count_files">Общее количество: <span id="files_count">0</span></div>
            </div>
            <?= Yii::$app->controller->renderPartial('modal-content'); ?>
        </div>
    </div>

<?php
$this->registerJsVar('stock_price', $param);
?>