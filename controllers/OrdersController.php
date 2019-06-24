<?php


namespace app\controllers;


use app\base\BaseWebController;
use app\models\OrdersBase;
use Codeception\Lib\Generator\Helper;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class OrdersController extends BaseWebController {

    public function actionIndex() {

        if (\Yii::$app->user->isGuest) {
            throw new HttpException(404, 'Страница не найдена');
        }
        if (!\Yii::$app->user->can('viewYourOrders')) {
            throw new HttpException(403, 'Страница не существует');
        }

        //        return OrdersBase::find()->andWhere(['client_id'=> \Yii::$app->user->id])->one();

        $model = ArrayHelper::toArray(OrdersBase::find(['client_id' => \Yii::$app->user->id])->all());
        if(!$model) {
            throw new HttpException(403, 'Не найдено');
        }
        return $this->render('showOrders', compact('model'));

    }

}