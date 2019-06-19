<?php

namespace app\controllers;

use app\base\BaseWebController;
use app\controllers\auth\AuthSignInActions;
use app\controllers\auth\AuthSignUpActions;


/**
 * Class authController
 *
 * @package app\controllers
 */
class AuthController extends BaseWebController {

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
}