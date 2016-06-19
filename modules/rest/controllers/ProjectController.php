<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-10-22
 * Time: 上午11:01
 */

namespace app\modules\rest\controllers;


use app\models\Project;
use yii\rest\ActiveController;

class ProjectController extends ActiveController{
    public $modelClass='app\models\Project';
} 