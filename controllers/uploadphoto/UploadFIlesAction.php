<?php

/**
 * Активатор UploadFIlesAction
 * Сердце проекта, загрузки  для печати.
 */

namespace app\controllers\uploadphoto;

use app\models\uploadphoto\UploadFIles;
use yii\base\Action;
use yii\web\UploadedFile;

class UploadFIlesAction extends Action {


    public function run() {

        $model = new UploadFIles;
        if (\Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstanceByName('file');
            $save = $model->upload();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $save;
        }
    }
}