<?php

namespace app\controllers;


use app\components\AccessRule;
use app\models\User2;
use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig'=>["class"=>AccessRule::className()],
                'rules' => [
                    [
                        'allow' => true,
//                        'roles' => ['@'],
                        'roles' => ['@'.User2::COMMON],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){
        echo "admin index";
    }
}