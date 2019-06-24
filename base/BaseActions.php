<?php


namespace app\base;


use yii\base\Action;
use yii\web\HttpException;

class BaseActions extends Action {
    public $title;

    public function run() {
        \Yii::$app->getView()->params['title'] = $this->title;
    }
}
