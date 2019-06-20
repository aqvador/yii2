<?php


namespace app\controllers;


use yii\base\Action;
use yii\web\HttpException;

class BaseActions extends Action {
    public $title;

    public function run() {
        \Yii::$app->getView()->params['title'] = $this->title;
        if (!\Yii::$app->user->isGuest) {

            if (!\Yii::$app->rbac->canCreateOrder) {
                throw new HttpException(403, 'Сюда нельзя тебе');
            }
            return $this->controller->goHome();
        }
    }
}
