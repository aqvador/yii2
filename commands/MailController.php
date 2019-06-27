<?php


namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;

class MailController extends Controller {

    protected $date;
    protected $mate;

    public function optionAliases() {
        return [
            'd' => 'date',
            'b' => 'bate',
            'm' => 'mate',
            'z' => 'zade'
        ];
    }

    public function options($actionID) {
        return [
            'date',
            'mate',
        ];
    }

    public function actionTest() {

        echo $this->mate . PHP_EOL;
        echo $this->date . PHP_EOL;

    }

    public function actionSendOrderManager() {

    }
}