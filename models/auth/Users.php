<?php

namespace app\models\auth;

/**
 * This is the model class for table "users".
 *
 * @property int    $id
 * @property string $email
 * @property string $passwordHash
 * @property string $authToken
 * @property string $authKet
 * @property string $createAt
 */
class Users extends UsersBase {

	const SCENARIO_SUGNUP = 'signup'; #регистрация
	const SCENARIO_SIGNIN = 'signin'; #авторизация

	public function setScenarioSignUp(){
		$this->setScenario(self::SCENARIO_SUGNUP);
	}

	public function setScenarioSigIn(){
		$this->setScenarioSingIn(self::SCENARIO_SIGNIN);
	}

	public function rules(){
		return array_merge(
			[
				['email', 'unique', 'on' => self::SCENARIO_SIGNIN],
				['email', 'exist', 'on' => self::SCENARIO_SIGNIN]
			]
			, parrent::rules()
		);
	}


}
