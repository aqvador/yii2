<?php

namespace app\commands;

use app\models\auth\Users;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

//php yii rbac-admin-assign/init 1
class RbacRoleAssignController extends Controller {

    public function actionInit($id, $setRole) {

        //Проверяем обязательный параметр id
        if (!$id || is_int($id)) {
            // throw new \yii\base\InvalidConfigException("param 'id' must be set");
            $this->stdout("Пустой id походу\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        //Есть ли пользователь с таким id
        $user = Users::findIdentity($id);
//        $user = $user->self::findIdentity($id);
        if (!$user) {
            // throw new \yii\base\InvalidConfigException("User witch id:'$id' is not found");
            $this->stdout("Юзер :'$id' не найден в нашей системе!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        //Получаем объект yii\rbac\DbManager, который назначили в конфиге для компонента authManager
        $authManager = \Yii::$app->authManager;

        //Получаем объект роли
        $role = $authManager->getRole($setRole);

        //Удаляем все роли пользователя
        $authManager->revokeAll($id);

        //Присваиваем роль админа по id
        $authManager->assign($role, $id);

        //Выводим сообщение об успехе и возвращаем соответствующий код
        $this->stdout("Готово! id=$id role=$setRole\n", Console::BOLD);
        return ExitCode::OK;

    }
}