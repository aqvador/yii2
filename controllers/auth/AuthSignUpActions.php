<?php

namespace app\controllers\auth;

use app\components\AuthComponent;
use app\controllers\BaseActions;
use app\models\auth\Users;
use yii\base\Action;

class AuthSignUpActions extends BaseActions {
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function run() {
        parent::run();
        $model = \Yii::createObject(Users::class);
        $model->setScenarioSignUp();

        if (\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post())) {
            if ($this->getAuthComponent()->signUp($model)) {
                return $this->controller->redirect(['/auth/sign-in']);
            };

        }

        return $this->controller->render('signup', compact('model'));


    }

    /** @return AuthComponent */
    private function getAuthComponent() {
        return \Yii::$app->auth;
    }
}

