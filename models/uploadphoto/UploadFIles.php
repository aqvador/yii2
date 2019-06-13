<?php

namespace app\models\uploadphoto;

use app\components\ImageResizeHelperComponent;
use yii\base\Model;
use yii\helpers\Html;

class Uploadfiles extends Model {
    /**
     * @var UploadedFile
     */
    public $image;
    public $folder;
    public $path;

    public function rules() {
        return [
            [['image'], 'image', 'extensions' => ['png', 'jpg'], 'maxWidth' => 5315, 'maxHeight' => 3543],
        ];
    }

    public function upload() {


        if ($this->validate()) {
            if(!$this->folder = \Yii::$app->session->get('folder')) return ['status', 'error', 'Нет каталога'];
            if(!$this->path = \Yii::$app->session->get('path')) return ['status' => 'error', 'Нет пути к каталогу'];
            //        $this->file = $_FILES['file'];
            $uploadfilemax = $this->path . '/max/';
            $uploadfilemin = $this->path . '/min/';
            $maxFile = $uploadfilemax . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs($maxFile);
            $minFile = ImageResizeHelperComponent::init()->image($maxFile, $this->image->baseName)->quality(20)->fit(700, 800);
            return [
                'status' => [
                    'min' => $minFile,
                    'max' => '/img/orders/' . $this->folder . '/max/' . $this->image->baseName . '.' . $this->image->extension
                ]
            ];
        } else {
             return ['status' => 'error', 'name' => $this->image->baseName . '.' . $this->image->extension];
        }
    }
    /*
                $companent = new SaveImageComponent;
                $companent->mime();
                $companent->accept();
                return $companent->resize();
    */
}