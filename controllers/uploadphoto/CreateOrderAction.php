<?php

namespace app\controllers\uploadphoto;

use app\models\uploadphoto\CreateOrder;
use yii\base\Action;

class CreateOrderAction extends Action {

    public $imageFile;
    public $tpl;

    public function run() {
        $model = new CreateOrder;
        $model->Сreate();
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'orderNumber' => $model->folder,
                'secureKey' => $model->secureKey,
                'tpl' => $this->controller->renderPartial('upload', ['model' => $model]),
                'block' => $this->controller->renderPartial('addFile')
            ];
        }
    }
}