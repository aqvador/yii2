<?php


namespace app\components;


use yii\base\Component;
use yii\rbac\ManagerInterface;

class RbacComponent extends Component {

    private function getAuthManager(): ManagerInterface {
        return \Yii::$app->authManager;
    }

    public function gen() {
        $authManager = $this->getAuthManager();
        $authManager->removeAll();
        $roles = ['admin' => 1, 'manager' => 1, 'user' => 1];

        foreach ($roles as $k => $role) {
            $$k = $authManager->createRole($k);
            $authManager->add($$k);
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

        $authManager->addChild($user, $viewYourOrders);
        $authManager->addChild($user, $createOrder);

        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $allpreveleges);


    }

}