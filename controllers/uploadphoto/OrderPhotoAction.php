<?php

/**
 * Активатор OrderPhotoAction
 * Оставляет  заказ от клиента на печать фотографий
 */


namespace app\controllers\uploadphoto;


use app\models\uploadphoto\OrderPhoto;
use yii\base\Action;

class OrderPhotoAction extends Action {

    public $realPrice;

    public function run() {

        $model = new OrderPhoto();

        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());
        }


        if (\Yii::$app->request->isAjax) {
            if ($model->validate()) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $model->realPrice;
            } else {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $model->errors;
                      return $model->errors;
            }
        }

    }


}

