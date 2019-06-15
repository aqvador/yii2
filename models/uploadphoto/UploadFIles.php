<?php

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
            $maxFile = $uploadfilemax . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs($maxFile);
            $minFile = ImageResizeHelperComponent::init()->image($maxFile, $this->image->baseName)->quality(20)->fit(700, 800);
            if ($minFile) {
                return [
                    'status' => [
                        'min' => $minFile,
                        'max' => '/img/orders/' . $this->folder . '/max/' . $this->image->baseName . '.' . $this->image->extension
                    ]
                ];
            } else  return ['status' => 'error', 'name' => $this->image->baseName . '.' . $this->image->extension];
        } else {
            return [
                'status' => 'error',
                'name' => $this->image->baseName . '.' . $this->image->extension . ' <br> ' . $this->errors['image'][0]
            ];
        }
    }
}