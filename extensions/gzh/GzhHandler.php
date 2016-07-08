<?php

namespace app\extensions\gzh;

use app\models\form\GzhForm;

class GzhHandler {
    /**
     * @var GzhForm
     */
    public $model;
    public function handle(){
        $event=$this->model->MsgType;
        $method="handle".ucfirst(strtolower($event));
        if(method_exists($this,$method)){
            return $this->$method;
        }
        return $this->handleDefault();
    }
    public function handleText(){
        $response=$this->model->getResponse();
        $response->Content="您的问题已收到，我们会在第一时间回复您";
        $response->MsgType=GzhForm::TEXT;
        $response->FuncFlag=0;
        return $response->toXml();
    }
    public function handleEvent(){
        $eventHandler=new GzhEventHandler();
        $eventHandler->model=$this->model;
        return $eventHandler->handle();
    }
    public function handleDefault(){
        return "success";
    }
}