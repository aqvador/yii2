<?php

/**
 * Активатор OrderPhotoAction
 * Оставляет  заказ от клиента на печать фотографий
 */


namespace app\controllers\uploadphoto;


use app\components\IntegrationRetailCRM;
use app\base\BaseActions;
use app\models\uploadphoto\OrderPhoto;

class OrderPhotoAction extends BaseActions {

    public $realPrice;

    /**
     * @return array|string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function run() {
        parent::run();

        $model = new OrderPhoto();

        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
        }


        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->validate()) {

                $crm = \Yii::createObject(IntegrationRetailCRM::class);
                $a = $crm->CreateOrderCRM($model);
                $model->saveOrder();
                return $a;
            } else {
                return $model->errors;

            }
        }

    }


}

