<?php

namespace app\models\auth;

use app\models\basemodel\BaseActiveRecord;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int    $id
 * @property string $email
 * @property string $passwordHash
 * @property string $authToken
 * @property string $authKet
 * @property string $createAt
 */
class UsersBase extends BaseActiveRecord {

	public static function tableName(){
		return 'users';
	}

	public function rules(){
		return [
			[['email', 'passwordHash'], 'required'],
			[['createAt'], 'safe'],
			[['email'], 'string', 'max' => 100],
			[['passwordHash', 'authToken'], 'string', 'max' => 300],
			[['authKet'], 'string', 'max' => 150],
//			[['email'], 'unique'],
		];
	}

	public function attributeLabels(){
		return [
			'id' => Yii::t('app', 'ID'),
			'email' => Yii::t('app', 'Email'),
			'passwordHash' => Yii::t('app', 'Password Hash'),
			'authToken' => Yii::t('app', 'Auth Token'),
			'authKet' => Yii::t('app', 'Auth Ket'),
			'createAt' => Yii::t('app', 'Create At'),
		];
	}
}
