<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $client_id Тут будет ID  заркгистрированного клиента на сайта
 * @property string $name Имя клиента оставившего заказ
 * @property int $orderNumCRM Номер заказа из CRM
 * @property int $clientIdCrm Сюда пишем id  клиента из CRM если он там найден
 * @property string $email Email  клиента оставившего заказ
 * @property string $phone Телефон клиента оставившего заказ
 * @property string $comment Комментарий клиента оставившего заказ
 * @property string $status
 * @property int $totalPrice Общая стоимость заказа клиента
 * @property string $eventtime дата, время создания заказа
 */
class OrdersBase extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'email', 'phone'], 'required'],
            [['orderNumCRM', 'clientIdCrm', 'totalPrice'], 'integer'],
            [['comment', 'status'], 'string'],
            [['eventtime'], 'safe'],
            [['client_id', 'email'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_id' => Yii::t('app', 'Client ID'),
            'name' => Yii::t('app', 'Name'),
            'orderNumCRM' => Yii::t('app', 'Order Num Crm'),
            'clientIdCrm' => Yii::t('app', 'Client Id Crm'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'comment' => Yii::t('app', 'Comment'),
            'status' => Yii::t('app', 'Status'),
            'totalPrice' => Yii::t('app', 'Total Price'),
            'eventtime' => Yii::t('app', 'Eventtime'),
        ];
    }
}
