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
            'signup' => [
                'class' => AuthSignUpActions::class
            ],
            'signIn' => [
                'class' => AuthSignInActions::class
            ]
        ];
    }
}