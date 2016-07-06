<?php

namespace app\models\form;
use yii\base\Model;

class GzhForm extends Model {
    public $FromUserName;
    public $ToUserName;
    public $Content;

    public function receive(){
        $postStr=$GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            foreach($this->attributes() as $attr){
                if(property_exists($postObj, $attr)){
                    $this->$attr=$postStr->$attr;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function response(){
        $response=new static();
        $response->FromUserName=$this->ToUserName;
        $response->ToUserName=$this->FromUserName;
        return $response->getResponseStr();
    }
    public function getResponseStr(){
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
        return sprintf($textTpl, $this->ToUserName, $this->FromUserName, time(), "text", "您提的问题我们正在处理...");
    }

}