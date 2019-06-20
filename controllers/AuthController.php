<?php

namespace app\controllers;

use app\controllers\auth\AuthSignInActions;
use app\controllers\auth\AuthSignUpActions;
use app\models\auth\Users;
use yii\web\Controller;


/**
 * Class authController
 *
 * @package app\controllers
 */
class AuthController extends Controller {

    /**
     * @return array
     */
    public function actions() {
        return [
            'sign-up' => [
                'class' => AuthSignUpActions::class,
                'title' => 'Регистрация'
            ],
            'sign-in' => [
                'class' => AuthSignInActions::class,
                'title' => 'Авторизация'
            ]
        ];
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogOut() {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}