<?php

use yii\db\Migration;

/**
 * Class m190617_053739_CreateBD
 */
class m190617_053739_CreateBD extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {


        $this->createTable('PhotoSize', [
            'id' => $this->primaryKey(),
            'size' => $this->string(50)->notNull()->comment('Размер фотографии'),
            'price' => $this->string(50)->notNull()->comment('Цена отпечатка'),
            'active' => $this->boolean()->notNull()->comment('Активировать, либо убрать с сайта. 0 или 1'),
            'position' => $this->boolean()->notNull()->comment('Позиция товава по списку на странице'),
            'chosen' => $this->boolean()->defaultValue(0)->comment('Какая фотография будет выбрана по умолчанию при старте проекта'),
            'type_paper' => $this->string(255)->comment('Пока не используемое поле. ДУмаю как его применить'),
            'dateCreate' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'client_id' => $this->string(100)->notNull()->comment('Тут будет ID  заркгистрированного клиента на сайта'),
            'name' => $this->string(50)->notNull()->comment('Имя клиента оставившего заказ'),
            'orderNumCRM' => $this->integer()->notNull()->comment('Номер заказа из CRM'),
            'clientIdCrm' => $this->integer()->comment('Сюда пишем id  клиента из CRM если он там найден'),
            'email' => $this->string(100)->notNull()->comment('Email  клиента оставившего заказ'),
            'phone' => $this->string(11)->notNull()->comment('Телефон клиента оставившего заказ'),
            'comment' => $this->text()->comment('Комментарий клиента оставившего заказ'),
            'status' => 'ENUM("open", "job", "close")',
            'totalPrice' => $this->integer(11)->notNull()->comment('Общая стоимость заказа клиента'),
            'eventtime' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('дата, время создания заказа')
        ]);


        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'phone' => $this->string(21)->notNull(),
            'email' => $this->string(100)->notNull()->unique(),
            'passwordHash' => $this->string(300)->notNull(),
            'authToken' => $this->string(300),
            'authKey' => $this->string(150),
            'createAt' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $user = [
            ['email' => 'admin@test.ru', 'password' => '111111', 'rule' => 'admin', 'name' => 'Анатолий'],
            ['email' => 'user@test.ru', 'password' => '111111', 'rule' => 'user', 'name' => 'Анатолий'],
            ['email' => 'as@alltel24.ru', 'password' => '111111', 'rule' => 'user', 'name' => 'Александр'],
            ['email' => 'as@pic66.ru', 'password' => '111111', 'rule' => 'admin', 'name' => 'Александр'],
        ];
        foreach ($user as $k => $v) {
            $this->insert('users', [
                'name' => $v['name'] . ' ' . $v['rule'],
                'phone' => '7950' . rand(1234567, 9876543),
                'email' => $v['email'],
                'passwordHash' => Yii::$app->security->generatePasswordHash($v['password']),
            ]);
            $userRole = Yii::$app->authManager->getRole($v['rule']);
            Yii::$app->authManager->assign($userRole, ++$k);
        }
        $insertStr = [
            ['size' => '9x13', 'price' => '10', 'active' => 1, 'position' => 1, 'chosen' => 0],
            ['size' => '10x15', 'price' => '15', 'active' => 1, 'position' => 2, 'chosen' => 1],
            ['size' => '11x15', 'price' => '15', 'active' => 1, 'position' => 3, 'chosen' => 0],
            ['size' => '13x18', 'price' => '17', 'active' => 1, 'position' => 4, 'chosen' => 0],
            ['size' => '15x15', 'price' => '20', 'active' => 1, 'position' => 5, 'chosen' => 0],
            ['size' => '15x20', 'price' => '20', 'active' => 1, 'position' => 6, 'chosen' => 0],
            ['size' => '20x30', 'price' => '30', 'active' => 1, 'position' => 7, 'chosen' => 0],
            ['size' => '21x30', 'price' => '30', 'active' => 1, 'position' => 8, 'chosen' => 0],
            ['size' => '20x40', 'price' => '60', 'active' => 1, 'position' => 9, 'chosen' => 0],
            ['size' => '30x42', 'price' => '75', 'active' => 1, 'position' => 10, 'chosen' => 0]
        ];
        foreach ($insertStr as $v) {
            $this->insert('PhotoSize', [
                'size' => $v['size'],
                'price' => $v['price'],
                'active' => $v['active'],
                'position' => $v['position'],
                'chosen' => $v['chosen']
            ]);
        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        //        echo "m190617_053739_CreateBD cannot be reverted.\n";

        $this->dropTable('PhotoSize');
        $this->dropTable('orders');
        $this->dropTable('users');

        //        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190617_053739_CreateBD cannot be reverted.\n";

        return false;
    }
    */
}
