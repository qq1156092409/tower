<?php

namespace app\modules\gii2\generators\service;

use yii\gii\CodeFile;

class Generator extends \yii\gii\Generator{
    public $target;
    public function requiredTemplates() {
        return ['controller.php','formModel.php','js.php'];
    }

    /**
     * @return CodeFile[]
     * @throws \yii\base\InvalidParamException
     */
    public function generate(){
        $files = [];
        $files[] = new CodeFile(
            \Yii::getAlias('@app/controllers/'.ucwords($this->target).'Controller.php'),
            $this->render("controller.php",["model"=>$this])
        );
        $files[] = new CodeFile(
            \Yii::getAlias('@app/models/form/'.ucwords($this->target).'Form.php'),
            $this->render("formModel.php",["model"=>$this])
        );
        $files[] = new CodeFile(
            \Yii::getAlias('@app/web/js/models/'.$this->target.'.js'),
            $this->render("js.php",["model"=>$this])
        );

        return $files;
    }
    public function getName(){
        return "service generator";
    }

    /**
     * @param $files CodeFile[]
     * @return array
     */
    public function getAnswers($files){
        $ret=[];
        foreach($files as $file){
//            is_file($file->path) or $ret[md5($file->path)]=1;//不替换文件
            $ret[md5($file->path)]=1;//替换所有文件
        }
        return $ret;
    }

}