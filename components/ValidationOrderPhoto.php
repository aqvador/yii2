<?php

/**
 * Компонент ValidationOrderPhoto
 * Валидирует файлы отправленные клиентом на печать.
 * Кроме валидации, данные компонент так же раскладывает файлы по нужным папкам
 * После работы валидатора, останется папка order в папке с заказом, а min и max  папки будут уничтожены
 *
 */

namespace app\components;


use yii\validators\Validator;

class ValidationOrderPhoto extends Validator {

    public function validateAttribute($model, $attribute) {
        /** @var  $order Готовый заказ. массив со всеми значениями */
        $order = json_decode(\Yii::$app->request->post('OrderPhoto')[$attribute], 1);
        /** @var  $tmp Данные о доступных размерах и их ценах */
        $tmp = \Yii::createObject(OrderPhotoComponent::class)->getSizePhoto();

        foreach ($tmp as $v) {
            $price[$v['size']] = $v['price'];
            $realPrice[$v['size']] = 0;
        }
        /** @var  $path Дериктория куда мы качали фотки клиента */
        $path = \Yii::$app->session->get('path');
        /** Если нет директории то валидация не пройдена */
        if (!is_dir($path)) {
            $model->addError($attribute, 'Запрошенного проекта не существует. Обратитесь к нам по телефону');
            return false;
        }

        foreach ($order as $k => $v) {
            /** Если клиент как то заказал фотки размеров которые недоступны, то валидация не пройдена */
            if (!isset($v['printSize'])) {
                $model->addError($attribute, 'Как то так получилось, что у нас нет, заказанного вами формата фото.');
                return false;
            }
            /** Формируем заказ раскладывая его по папкам */
            $realPrice[$v['printSize']] += $price[$v['printSize']] * $v['qty'];
            $file = $path . '/max/' . trim($v['fileName']);
            $crop = ($v['kadr']) ? '/' : '_not_crop/';
            $new_dir = $path . '/order/' . $v['printSize'] . $crop . $v['paperType'] . '/';

            if (!is_dir($new_dir)) {
                mkdir($new_dir, 0777, true);
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
        exec('rm -Rf ' . $path . '/max/');
        exec('rm -Rf ' . $path . '/min/');
        /** @var  $totalPrice  Сформируем  реальную стоимость заказа */
        $totalPrice = 0;
        foreach ($realPrice as $k => $v) {
            if ($v === 0)
                unset($realPrice[$k]); else $totalPrice += $realPrice[$v];
        }

        $model->realPrice = $realPrice;
        $model->totalPtice = $totalPrice;
        return true;
    }

}