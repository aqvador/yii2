<?php

/**
 * Модель OrderPhoto
 * Оставляет заказы от клиентов, на печать фотографий
 */


namespace app\models\uploadphoto;


use app\components\OrderPhotoComponent;
use app\components\ValidationOrderPhoto;
use yii\base\Model;

class OrderPhoto extends Model {

    public $name;
    public $email;
    public $phone;
    public $comment;
    public $order;
    public $realPrice;
    public $Answer;
    public $totalPrice;
    public $orderNumCRM;
    public $clientIdCrm;


    public function rules() {
        return [
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
                'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/',
            ],
            [
                'comment',
                'string'
            ],
            [
                'order',
                ValidationOrderPhoto::className()
            ],
            [
                'phone',
                'filter',
                'filter' => function ($value) {
                    return preg_replace("/[^0-9]/", '', $value);
                }
            ],

        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'comment' => 'Комметраний',
        ];
    }

    public function saveOrder() {
        return \Yii::createObject(OrderPhotoComponent::class)->pushSaveOrder($this);
    }

}