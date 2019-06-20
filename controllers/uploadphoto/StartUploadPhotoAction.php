<?php

/**
 * Активатор StartUploadPhotoAction
 * Начало создания проекта для заказа печати фотографий
 * Создает директории проекта и возвращает подключаемый шаблов в DOM
 */

namespace app\controllers\uploadphoto;

use app\base\BaseActions;
use app\models\uploadphoto\StartUploadPhoto;

class StartUploadPhotoAction extends BaseActions {

    public $imageFile;
    public $tpl;

    public function run() {

        parent::run();
        
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