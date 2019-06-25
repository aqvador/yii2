<?php


namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;

class MailController extends Controller {

    public function actionSendOrderManager() {

        echo PHP_EOL;
        echo $this->ansiFormat('Калькулятор STDIN:', Console::FG_BLUE) . PHP_EOL;
    }
}