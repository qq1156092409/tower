<?php

namespace app\extensions\gzh;
use app\models\form\GzhForm;

/**
 * Class GzhEventHandler
 * @package app\extensions\gzh
 */
class GzhEventHandler {
    /**
     * @var GzhForm
     */
    public $model;
    public function handle(){
        $event=$this->model->Event;
        $method="handle".ucfirst(strtolower($event));
        if(method_exists($this,$method)){
            return $this->$method;
        }
        return $this->handleDefault();
    }
    public function handleSubscribe(){
        $response=$this->model->getResponse();
        $response->Content="亲，你来啦！";
        $response->MsgType=GzhForm::TEXT;
        $response->FuncFlag=0;
        return $response->toXml();
    }
    public function handleUnsubscribe(){
        return "success";
    }
    public function handleScan(){
        return "success";
    }
    public function handleClick(){
        return "success";
    }
    public function handleView(){
        return "success";
    }
    public function handleDefault(){
        return "success";
    }

}