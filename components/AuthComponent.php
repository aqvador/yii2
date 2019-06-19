<?php


namespace app\components;


use app\models\auth\Users;
use yii\base\Component;

class AuthComponent extends Component {

    /**
     * @param Users $model
     * @return bool
     * @throws \yii\base\Exception
     */
    public function signUp(Users &$model):bool {
        if (!$model->validate(['email', 'password'])) {
            return false;
        }

        $model->passwordHash = $this->generatePasswordHash($model->password);

        if (!$model->save()) {
            return false;
        }

        return true;
    }

    /**
     * @param $password
     * @return string
     * @throws \yii\base\Exception
     */
    public function generatePasswordHash($password) {
        return \Yii::$app->security->generatePasswordHash($password);


    }




    /** Тут идет Авторизация Юзера  */

    /**
     * @param Users $model
     * @return bool
     */
    public function signIn(Users &$model):bool {

        if (!$model->validate(['email', 'password'])) {
            return false;
        }

        $user = $this->getUserByEmail($model->email);
        if (!$this->validatePassword($model->password, $user->passwordHash)) {
            $model->addError('email', 'Не верный логин или пароль, попробуйте еще раз.');
            return false;
        }

        return \Yii::$app->user->login($user, 600);
    }

    private function getUserByEmail($email):Users {
        return Users::find()->andWhere(['email' => $email])->limit(1)->one();
    }

    private function validatePassword($password, $passwordHash) {
        return \Yii::$app->security->validatePassword($password, $passwordHash);
    }


}