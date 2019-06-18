<?php

namespace app\controllers;

use app\base\BaseWebController;
use app\controllers\auth\authSignInActions;
use app\controllers\auth\authSignUpActions;

/**
 * Class auth
 *
 * @package app\controllers
 */
class auth extends BaseWebController {

	/**
	 * @return array
	 */
	public function actions(){
		return [
			'signUp' =>
				['class' => authSignUpActions::class],
			'signIn' =>
				['class' => authSignInActions::class]
		];
	}
}