<?php

namespace app\models\auth;

use app\models\Orders;
use yii\caching\TagDependency;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $passwordHash
 * @property string $authToken
 * @property string $authKey
 * @property string $createAt
 */
class Users extends UsersBase implements IdentityInterface {

    public $password;
    public $confirmPass;


    const SCENARIO_SUGNUP = 'signup'; #Регистрация
    const SCENARIO_SIGNIN = 'signin'; #Авторизация

    public function setScenarioSignUp() {
        $this->setScenario(self::SCENARIO_SUGNUP);
        return $this;
    }

    public function setScenarioSignIn() {
        $this->setScenario(self::SCENARIO_SIGNIN);
        return $this;
    }

    public function rules() {
        return array_merge([
            [['email'], 'exist', 'on' => self::SCENARIO_SIGNIN],
            [['email', 'phone'], 'unique', 'on' => self::SCENARIO_SUGNUP],
            [['name', 'phone'], 'required', 'on' => self::SCENARIO_SUGNUP],
            [
                ['phone'],
                'match',
                'pattern' => '/^\+7\s\([3489]{1}[0-9]{2}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/',
                'on' => self::SCENARIO_SUGNUP
            ],
            [['password'], 'string', 'min' => 6],
            [['confirmPass'], 'compare', 'compareAttribute' => 'password', 'on' => self::SCENARIO_SUGNUP],
            [['confirmPass'], 'string', 'min' => 6, 'on' => self::SCENARIO_SUGNUP],
            [
                ['phone'],
                'filter',
                'filter' => function ($value) {
                    return preg_replace("/[^0-9]/", '', $value);
                },
                'on' => self::SCENARIO_SUGNUP
            ],
        ], parent::rules());
    }

    public function attributeLabels() {
        return [
            'name' => 'Имя',
            'password' => 'Пароль',
            'confirmPass' => 'Повторите пароль'
        ];
    }

    /**
     * @return string
     */
    public function getUsername(){
        return $this->email;
    }


    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id) {
        /** Сброс тега . бывает не работает. надо Юзать редис */
        //TagDependency::invalidate(\Yii::$app->cache, \Yii::$app->user->id);
       return Users::find()
           ->andWhere(['id'=> $id])
           ->cache(3600*24, new TagDependency(['tags' => \Yii::$app->user->id]))
           ->one();
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\authController\HttpBearerAuth]] will set this parameter to be `yii\filters\authController\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId() {
       return  $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled. The returned key will be stored on the
     * client side as a cookie and will be used to authenticate user even if PHP session has been expired.
     *
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey() {
      return  $this->authKey;
    }

    /**
     * Validates the given authController key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given authController key
     * @return bool whether the given authController key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey):bool {
       return $this->authKey==$authKey;
    }

    public function getOrders(){
        return $this->hasMany(Orders::class, ['client_id    ' => 'id']);
    }
}
