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

        try {
            return $query->select(['*'])->from('PhotoSize')->andWhere(['active' => 1])->orderBy(['position' => 4])->createCommand()->queryAll();
        } catch (Exception $e) {
        }
    }

}