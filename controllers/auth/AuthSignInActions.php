<?php

namespace app\controllers\auth;

use app\base\BaseActions;
use app\components\AuthComponent;
use app\models\auth\Users;

class AuthSignInActions extends BaseActions {

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function run() {
        parent::run();

        $model = \Yii::createObject(Users::class);
        $model->setScenarioSignIn();

        if (\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post())) {
            if ($this->getAuthComponent()->signIn($model)) {
                return $this->controller->redirect(['/uploadphoto/index']);
            }

        }

        return $this->controller->render('signin', compact('model'));

    }

    /** @return AuthComponent */
    private function getAuthComponent() {
        return \Yii::$app->auth;
    }

}