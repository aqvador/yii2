<?php

namespace app\controllers;

use app\base\BaseWebController;
use app\components\OrderPhotoComponent;
use app\controllers\uploadphoto\CreateOrderAction;
use app\controllers\uploadphoto\OrderPhotoAction;
use app\controllers\uploadphoto\UploadFIlesAction;
use app\models\uploadphoto\OrderPhoto;

class UploadphotoController extends BaseWebController {


    public function actions() {
        return [
            'numorders' => [
                'class' => CreateOrderAction::class
            ],
            'uploadfiles' => [
                'class' => UploadFIlesAction::class,
            ],
            'orderphoto' => [
                'class' => OrderPhotoAction::class,
            ]
        ];
    }

    public function actionIndex() {
        $model = new OrderPhoto();
        $comp = \Yii::createObject(OrderPhotoComponent::class);
        $size = $comp->getSizePhoto();


        return $this->render('index', compact('model', 'size'));
    }
}