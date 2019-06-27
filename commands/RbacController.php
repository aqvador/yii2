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
            $objRole[$k] = $authManager->createRole($k);
            $authManager->add($objRole[$k]);
        }

   $createOrder = $authManager->createPermission('createOrder');
        $createOrder->description = 'Сделать заказ';
        $authManager->add($createOrder);

        $viewYourOrders = $authManager->createPermission('viewYourOrders');
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

        $authManager->addChild($objRole['user'], $viewYourOrders);
        $authManager->addChild($objRole['user'], $createOrder);

        $authManager->addChild($objRole['admin'], $objRole['user']);
        $authManager->addChild($objRole['admin'], $allpreveleges);
        echo "\nВсе права наполнены\n";
    }
}

