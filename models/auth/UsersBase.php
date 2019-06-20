<?php

namespace app\models\auth;

use app\base\BaseActiveRecord;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $passwordHash
 * @property string $authToken
 * @property string $authKey
 * @property string $createAt
 */
class UsersBase extends BaseActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['email'], 'required'],
            [['createAt'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 21],
            [['email'], 'string', 'max' => 100],
            [['passwordHash', 'authToken'], 'string', 'max' => 300],
            [['authKey'], 'string', 'max' => 150],
            [['email'], 'email'],
            //            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'passwordHash' => Yii::t('app', 'Password Hash'),
            'authToken' => Yii::t('app', 'Auth Token'),
            'authKey' => Yii::t('app', 'Auth Ket'),
            'createAt' => Yii::t('app', 'Create At'),
        ];
    }
}
