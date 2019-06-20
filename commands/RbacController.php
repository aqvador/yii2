<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller {
    public function actionInit() {
        $authManager = Yii::$app->authManager;
        $authManager->removeAll();
        $roles = ['admin' => 1, 'manager' => 1, 'user' => 1];
        foreach ($roles as $k => $role) {
            $$k = $authManager->createRole($k);
            $authManager->add($$k);
        }

        $createOrder = $authManager->createPermission('createOrder');
        $createOrder->description = 'Сделать заказ';
        $authManager->add($createOrder);

        $viewYourOrders = $authManager->createPermission('uploadphoto');
        $viewYourOrders->description = 'Просмотр своих заказов';
        $authManager->add($viewYourOrders);

        $jobOrder = $authManager->createPermission('jobOrder');
        $jobOrder->description = 'Работа с заказами для менеджера';
        $authManager->add($jobOrder);

        $allpreveleges = $authManager->createPermission('allpreveleges');
        $allpreveleges->description = 'Полные права';
        $authManager->add($allpreveleges);

        /** @var  $user */ /** @var  $manager */
        /** @var   $admin */

        $authManager->addChild($user, $viewYourOrders);
        $authManager->addChild($user, $createOrder);

        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $allpreveleges);
        echo "\nВсе права наполнены
        \n";
    }

    public function canCreateOrder(){
        return \Yii::$app->user->can('uploadphoto');
    }
}
