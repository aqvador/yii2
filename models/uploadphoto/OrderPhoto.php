<?php


namespace app\models\uploadphoto;

use yii\base\Model;

class OrderPhoto extends Model {

    public $name;
    public $email;
    public $phone;
    public $comment;

    public function rules() {
        return [
            [
                ['name', 'email', 'phone'],
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
                'comment', 'string'
            ]
        ];
    }

}