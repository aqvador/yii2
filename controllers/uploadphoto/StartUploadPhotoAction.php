<?php

/**
 * Активатор StartUploadPhotoAction
 * Начало создания проекта для заказа печати фотографий
 * Создает директории проекта и возвращает подключаемый шаблов в DOM
 */

namespace app\controllers\uploadphoto;

use app\models\uploadphoto\StartUploadPhoto;
use yii\base\Action;

class StartUploadPhotoAction extends Action {

    public $imageFile;
    public $tpl;

    public function run() {
        $model = new StartUploadPhoto;
        $model->Сreate();
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'orderNumber' => $model->folder,
                'secureKey' => $model->secureKey,
                'block' => $this->controller->renderPartial('addFile')
            ];
        }
    }
}