<?php


namespace app\controllers;


use yii\base\Action;

class BaseActions extends Action {
    public $title;

    public function run() {
        \Yii::$app->getView()->params['title'] = $this->title;
    }
}