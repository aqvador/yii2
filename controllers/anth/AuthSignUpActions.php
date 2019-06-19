<?php

namespace app\controllers\auth;

use app\models\auth\Users;
use yii\base\Action;

class AuthSignUpActions extends Action {

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function run(){
	    $model = \Yii::createObject(Users::class);

	    return $this->controller->render('signup', compact('model'));


	}
}

