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
            return call_user_func([$this,$method]);
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
        $content='你好，如果遇到使用问题，可以先查看 <a href="https://tower.im/help">帮助中心</a>，自助解决。
若没有找到答案，请直接在下方回复你的问题，我们会及时给予解答！（即使是在节假日和下班时间，你也可能会很快收到回复哦）';
        $content2='请选择你管理的团队
[ 1 ] 方片集团
请回复相应编号选择
你还可以<a href="https://tower.im/teams/new">创建新团队</a>';
        $response=$this->model->getResponse();
        $response->MsgType=GzhForm::TEXT;
        $response->FuncFlag=0;
        if($this->model->EventKey=="contact-service"){
            $response->Content=$content;
        }elseif($this->model->EventKey=="invite-member"){
            $response->Content=$content2;
        }else{
            return "success";
        }
        return $response->toXml();
    }
    public function handleView(){
        return "success";
    }
    public function handleDefault(){
        return "success";
    }

}