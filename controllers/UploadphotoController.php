<?php

/**
 * Контроллер UploadphotoController
 * Загрузка фотографий для печати
 * Имеет 3 Активатора
 * numorders    ->  StartUploadPhotoAction  => Страртуем создание проекта
 * uploadfiles  ->  UploadFIlesAction       => Разрузка фотографий в форму
 * orderphoto   ->  OrderPhotoAction        => Оформление заказа печати фотографий
 *
 * actionIndex Просто рендерит страницу.
 */

namespace app\controllers;

use app\base\BaseWebController;
use app\components\OrderPhotoComponent;
use app\controllers\uploadphoto\StartUploadPhotoAction;
use app\controllers\uploadphoto\OrderPhotoAction;
use app\controllers\uploadphoto\UploadFIlesAction;
use app\models\uploadphoto\OrderPhoto;

class UploadphotoController extends BaseWebController {


    public function actions() {
        return [
            'numorders' => [
                'class' => StartUploadPhotoAction::class
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