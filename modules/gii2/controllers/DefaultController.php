<?php

namespace app\modules\gii2\controllers;

use app\modules\gii2\generators\service\Generator;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @var Generator
     */
    public $generator;
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionService($target=null){
        $target = "test2";
        $generator = $this->loadGenerator("service");
        $generator->target=$target;
        $generator->template = "default";
        $files=$generator->generate();
        $results=[];
        $generator->save($files,$generator->getAnswers($files),$results);
        echo 1;
    }

    /**
     * @param $id
     * @return Generator
     * @throws NotFoundHttpException
     */
    protected function loadGenerator($id)
    {
        if (isset($this->module->generators[$id])) {
            $this->generator = $this->module->generators[$id];
            $this->generator->loadStickyAttributes();
            $this->generator->load($_POST);

            return $this->generator;
        } else {
            throw new NotFoundHttpException("Code generator not found: $id");
        }
    }
}
