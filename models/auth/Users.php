<?php

namespace app\models\auth;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $passwordHash
 * @property string $authToken
 * @property string $authKet
 * @property string $createAt
 */
class Users extends UsersBase {

    public $password;


    const SCENARIO_SUGNUP = 'signup'; #Регистрация
    const SCENARIO_SIGNIN = 'signin'; #Авторизация

    public function setScenarioSignUp() {
        $this->setScenario(self::SCENARIO_SUGNUP);
        return $this;
    }

    public function setScenarioSigIn() {
        $this->setScenario(self::SCENARIO_SIGNIN);
        return $this;
    }

    public function rules() {
        return array_merge([
                ['email', 'unique', 'on' => self::SCENARIO_SUGNUP],
                ['email', 'exist', 'on' => self::SCENARIO_SIGNIN],
                ['password', 'string', 'min' => 6]
            ], parent::rules());
    }


}
