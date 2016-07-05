<?php

namespace app\models\form;
use yii\base\Model;

class GzhForm extends Model {
    const VALID = "valid";
    const ANSWER = "answer";
    const TOKEN="weixin";

    public $signature;
    public $timestamp;
    public $nonce;
    public $echostr;

    public $FromUserName;
    public $ToUserName;
    public $Content;

    private $_ret;

    public function scenarios(){
        return [
            self::VALID=>["signature","timestamp","nonce","echostr"],
            self::ANSWER=>["FromUserName","ToUserName","Content"],
        ];
    }
    public function rules(){
        return [
            ["signature","checkSignature"],
        ];
    }
    public function checkSignature($attr){
        $tmpArr = array(self::TOKEN, $this->timestamp, $this->nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr != $this->signature ){
            $this->addError($attr, "校验失败");
        }
    }

    public function valid(){
        if($flag=$this->validate()){
            $this->_ret=$this->echostr;
        }
        return $flag;
    }
    public function answer($validate=true){
        if($validate && !$this->validate()) return false;
        $this->processAnswer($this->getAnswer());
        return true;
    }
    private function processAnswer($answer){
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
        $this->_ret = sprintf($textTpl, $this->FromUserName, $this->ToUserName, time(), "text", $answer);
    }
    private function getAnswer(){
        return "回复:".$this->Content;
    }
    public function getRet(){
        return $this->_ret;
    }


}