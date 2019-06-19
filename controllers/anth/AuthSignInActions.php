<?php

namespace app\controllers\auth;

use yii\base\Action;

class AuthSignInActions extends Action {

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function run(){

	      $model = \Yii::createObject(Users::class);

	    return $this->controller->render('signup', compact('model'));

	}

}