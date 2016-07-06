<?php

namespace app\models\form;
use yii\base\Model;

class GzhValidForm extends Model {
    const TOKEN="weixin";

    public $signature;
    public $timestamp;
    public $nonce;
    public $echostr;

    public function scenarios(){
        return [
            self::SCENARIO_DEFAULT=>["signature","timestamp","nonce","echostr"],
        ];
    }
    public function rules(){
        return [
            [["signature","timestamp","nonce","echostr"],"required"],
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
    public function response(){
        if($this->validate()){
            return $this->echostr;
        }
        return "";
    }
}