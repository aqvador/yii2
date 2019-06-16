<?php

/**
 * Модель загрузки фотографий для печати
 * Сердце  проекта по печати фотографий
 *
 *
 */

namespace app\models\uploadphoto;

use app\components\ImageResizeHelperComponent;
use yii\base\Model;


class Uploadfiles extends Model {
    /**
     * @var UploadedFile
     */
    public $image;
    public $folder;
    public $path;

    public function rules() {
        return [
            [
                ['image'],
                'image',
                'extensions' => ['png', 'jpg'],
                'minWidth' => 200,
                'maxWidth' => 5315,
                'minHeight' => 200,
                'maxHeight' => 3543,
                'maxSize' => 1024 * 1024 * 25,
                'minSize' => 102400
            ],
            [
                'image',
                'castomValidationImageName'
            ]
        ];
    }

    public function upload() {


        if ($this->validate()) {
            if (!$this->folder = \Yii::$app->session->get('folder'))
                return ['status', 'error', 'Нет каталога'];
            if (!$this->path = \Yii::$app->session->get('path'))
                return ['status' => 'error', 'Нет пути к каталогу'];
            $uploadfilemax = $this->path . '/max/';
            $uploadfilemin = $this->path . '/min/';
            $file = $this->image->baseName . '.' . $this->image->extension;
            $maxFile = $uploadfilemax . $file;
            $this->image->saveAs($maxFile);
            $minFile = ImageResizeHelperComponent::init()->image($maxFile, $this->image->baseName)->quality(20)->fit(700, 800);
            if ($minFile) {
                return [
                    'status' => [
                        'min' => $minFile,
                        'max' => '/img/orders/' . $this->folder . '/max/' . $file
                    ]
                ];
            } else  return [
                'status' => 'error',
                'name' => $file,
                'textError' => "Не удалось  загрузить изображение <br><b>$file</b><br> по всей видимости с ним что-то не то"
            ];
        } else {
            $err = $this->errors['image'][0];
            return [
                'status' => 'error',
                'textError' => "<br><b>$err</b><br>"
            ];
        }
    }

    public function castomValidationImageName($attribute, $params) {
        if (mb_strlen($this->image->baseName) > 50)
            $this->addError($attribute, "Длинна имени файла<br> <b>$this->image</b> <br> должна быть меньше 50 символов");

    }
}