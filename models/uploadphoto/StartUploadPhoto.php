<?php

/**
 * Модель StartUploadPhoto
 * Стартует создание проекта по загрузке фото
 * Именно этот класс, создает изначально папки проекта
 * устанавливате нужные значения для сессии
 */

namespace app\models\uploadphoto;

use yii\base\Model;

Class StartUploadPhoto extends Model {

    public $folder;
    public $folders = ['min', 'max', 'order'];
    public $path;
    public $secureKey;
    public $imageFile;


    public function Сreate() {
        $this->folder = substr(time(), 1, 10) * rand(1000, rand(1500, 3500)); // упорство ))
        $this->secureKey = md5($this->folder + rand(20, 100)); // упорство по меньше =)
        $path = \Yii::getAlias('@webroot') . '/img/orders/' . $this->folder;
        \Yii::$app->session->set('secureKey', $this->secureKey);
        \Yii::$app->session->set('folder', $this->folder);
        \Yii::$app->session->set('path', $path);

        foreach ($this->folders as $k => $v) {
            mkdir($path . '/' . $v, 0777, true);
            if (!is_dir($path . '/' . $v))
                return false;
        }
        return true;
    }
}