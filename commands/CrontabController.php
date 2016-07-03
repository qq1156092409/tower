<?php

namespace app\commands;
use yii\console\Controller;

class CrontabController extends Controller
{
    public function actionTest(){
        echo "haha-".date("Y-m-d H:i:s");exit;
    }

}