<?php


namespace app\controllers\uploadphoto;


use app\models\uploadphoto\OrderPhoto;
use yii\base\Action;
use yii\validators\Validator;

class OrderPhotoAction extends Action {

    public function run() {

        $model = new OrderPhoto();


        if (\Yii::$app->request->isAjax) {
             if ($model->validate()) {
                 return 'все ок';
             } else  return 'Заполните все в соответствии с требованиями!';
        }

    }


}