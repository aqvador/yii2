<?php

/**
 * Активатор UploadFIlesAction
 * Сердце проекта, загрузки  для печати.
 */

namespace app\controllers\uploadphoto;

use app\controllers\BaseActions;
use app\models\uploadphoto\UploadFIles;
use yii\web\UploadedFile;

class UploadFIlesAction extends BaseActions {


    public function run() {
        parent::run();
        $model = new UploadFIles;
        if (\Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstanceByName('file');
            $save = $model->upload();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $save;
        }
    }
}