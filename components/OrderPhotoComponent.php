<?php

/**
 * Компонент для запросов в Базе данных
 * Используется для контроллера UploadphotoController
 */


namespace app\components;


use yii\base\Component;
use yii\db\Connection;
use yii\db\Exception;
use yii\db\Query;

class OrderPhotoComponent extends Component {

    /** @var Connection */
    public $connection;

    public function init() {
        $this->connection = \Yii::$app->db;
        parent::init();
    }

    public function getSizePhoto() {
        $query = new Query();

        return $query->select(['*'])->from('PhotoSize')->andWhere(['active' => 1])->orderBy(['position' => 4])->createCommand()->queryAll();
    }

    public function pushSaveOrder($model) {
        /** @var  $model \app\models\uploadphoto\OrderPhoto */
        $query = new Query();
        $client_id = (isset(\Yii::$app->session->get('user')['clientId'])) ? \Yii::$app->session->get('user')['clientId'] : 'guest_' . $model->name . '_' . date('Y-m-d H:i:s');


        return $query->createCommand()->insert('orders', [
            'client_id' => $client_id,
            'name' => $model->name,
            'orderNumCRM' => $model->orderNumCRM,
            'clientIdCrm' => $model->clientIdCrm,
            'email' => $model->email,
            'phone' => preg_replace("/[^0-9]/", '', $model->phone),
            'comment' => $model->comment,
            'status' => 'open',
            'totalPrice' => $model->totalPrice
        ])->execute();


    }

}