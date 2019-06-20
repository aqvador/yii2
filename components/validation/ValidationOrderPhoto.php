<?php

/**
 * Компонент ValidationOrderPhoto
 * Валидирует файлы отправленные клиентом на печать.
 * Кроме валидации, данные компонент так же раскладывает файлы по нужным папкам
 * После работы валидатора, останется папка order в папке с заказом, а min и max  папки будут уничтожены
 *
 */

namespace app\components\validation;


use app\components\OrderPhotoComponent;
use yii\helpers\FileHelper;
use yii\validators\Validator;

class ValidationOrderPhoto extends Validator {

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     * @return bool|void
     * @throws \yii\base\ErrorException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function validateAttribute($model, $attribute) {
        $order = json_decode(\Yii::$app->request->post('OrderPhoto')[$attribute], 1);
        $tmp = \Yii::createObject(OrderPhotoComponent::class)->getSizePhoto();

        foreach ($tmp as $v) {
            $price[$v['size']] = $v['price'];
        }
        $path = \Yii::$app->session->get('path');
        /** Если нет директории то валидация не пройдена */
        if (!is_dir($path)) {
            $model->addError($attribute, 'Запрошенного проекта не существует. Обратитесь к нам по телефону');
            return false;
        }
        $realPrice = [];
        foreach ($order as $k => $v) {
            /** Если клиент как то заказал фотки размеров которые недоступны, то валидация не пройдена */
            if (!isset($v['printSize'])) {
                $model->addError($attribute, 'Как то так получилось, что у нас нет, заказанного вами формата фото.');
                return false;
            }
            /** Формируем массив для CRM. создадим пустые ключи если их еще не было  */
            if (!isset($realPrice[$v['printSize']][$v['paperType']]['sum'])) {
                $realPrice[$v['printSize']][$v['paperType']]['sum'] = 0;
                $realPrice[$v['printSize']][$v['paperType']]['pcs'] = 0;
            }
            /** Формируем заказ раскладывая его по папкам */
            $realPrice[$v['printSize']][$v['paperType']]['sum'] += $price[$v['printSize']] * $v['qty'];
            $realPrice[$v['printSize']][$v['paperType']]['pcs'] += $v['qty'];
            $file = $path . '/max/' . trim($v['fileName']);
            $crop = ($v['kadr']) ? '/' : '_not_crop/';
            $new_dir = $path . '/order/' . $v['printSize'] . $crop . $v['paperType'] . '/';

            if (!is_dir($new_dir)) {
                FileHelper::createDirectory($new_dir, 0777, 1);
            }
            /** Если у клиента несколько фото, одного размера и одной бумаги, создадим компии этих фото
             *  Что бы менеджер работающий с заказом, не  путался по копиям тех или иных фото
             */
            for ($i = 0; $i < $v['qty']; $i++) {
                $c = $i + 1;
                copy($file, $new_dir . $c . '_' . $v['fileName']);
            }
        }
        /** После перекопирования всех фото,  сожно удалить все файлы проекта.  */
        FileHelper::removeDirectory($path . '/max/');
        FileHelper::removeDirectory($path . '/min/');
        $totalPrice = 0;
        foreach ($realPrice as $k => $v) {
            foreach ($v as $item) {
                if ($item['sum'] != 0)
                    $totalPrice += $item['sum'];
            }
        }
        $model->realPrice = $realPrice;
        $model->totalPrice = $totalPrice;
        return true;
    }

}