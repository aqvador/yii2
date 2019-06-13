<?php

namespace app\controllers;

use app\base\BaseWebController;
use app\controllers\uploadphoto\CreateOrderAction;
use app\controllers\uploadphoto\OrdesAsAction;
use app\controllers\uploadphoto\UploadFIlesAction;

class UploadphotoController extends BaseWebController {


	public function actions(){
		return [
			'numorders' => [
				'class' => CreateOrderAction::class
			],
			'uploadfiles' => [
				'class' => UploadFIlesAction::class,
			],
			'orderas' => [
				'class' => OrdesAsAction::class,
			]
		];
	}

	public function actionIndex(){
		return $this->render('index', ['name' => 'sazsfjnh']);
	}
}