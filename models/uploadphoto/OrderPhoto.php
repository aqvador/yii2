<?php

/**
 * Модель OrderPhoto
 * Оставляет заказы от клиентов, на печать фотографий
 */


namespace app\models\uploadphoto;


use app\components\OrderPhotoComponent;
use app\components\validation\ValidationOrderPhoto;
use app\models\OrdersBase;
use yii\base\Model;

class OrderPhoto extends OrdersBase {

    public $order;
    public $realPrice;
    public $Answer;


    public function rules() {
        return array_merge([
            [
                ['name', 'email', 'phone', 'order'],
                'required'
            ],
            [
                'email',
                'email'
            ],
            [
                'phone',
                'match',
                'pattern' => '/^\+7\s\([3489]{1}[0-9]{2}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/',
            ],
            [
                'comment',
                'string'
            ],
            [
                'order',
                ValidationOrderPhoto::class
            ],
            [
                'phone',
                'filter',
                'filter' => function ($value) {
                    return preg_replace("/[^0-9]/", '', $value);
                }
            ],

        ], parent::rules());
    }

    public function attributeLabels() {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'comment' => 'Комметраний',
        ];
    }

    /**
     * @return int
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function saveOrder() {
               $this->client_id = \Yii::$app->user->id;
               return $this->save(false);
    }

}