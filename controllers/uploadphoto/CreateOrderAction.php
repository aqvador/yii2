<?php

namespace app\controllers\uploadphoto;

use app\models\uploadphoto\CreateOrder;
use yii\base\Action;

class CreateOrderAction extends Action {

	public $imageFile;
	public $tpl;

	public function run(){
		sleep(1);
		$model = new CreateOrder;
		if($this->tpl == 'no') $model->Сreate();
		if(\Yii::$app->request->isAjax){
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			if($this->tpl == 'no') return ['orderNumber' => $model->folder, 'secureKey' => $model->secureKey]; // это ваш массив даннных для ответа
			else{
				return $this->controller->renderPartial('upload', ['model' => $model]);
			}
		}
	}
}