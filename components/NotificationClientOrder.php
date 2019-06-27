<?php


namespace app\components;


use yii\base\Component;

class NotificationClientOrder extends Component {

/** @var $model \app\models\uploadphoto\OrderPhoto */
    public function sendNotification($model = null):bool {
        if (!$model)return false;
        $mail = \Yii::$app->mailer->compose('notification', compact('model'))
                    ->setTo($model->email)
                    ->setFrom(['noreply@pic66.ru' => 'Pic66.ru'])
                    ->setSubject('Pic66 Ваш заказ номер: ' . $model->orderNumCRM)
                    ->send();
        // тут будет лог;
        return $mail;
    }

}