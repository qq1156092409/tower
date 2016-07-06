<?php

namespace app\models\form;
use yii\base\Model;

class GzhForm extends Model {
    const TEXT="text";

    public $FromUserName;
    public $ToUserName;
    public $Content;
    public $CreateTime;
    public $MsgType;
    public $FuncFlag;

    public static $ignoreCdata=array(
        "FuncFlag",
        "CreateTime",
        "FuncFlag",
    );

    public function receive(){
        $postStr=$GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            foreach($this->attributes() as $attr){
                if(property_exists($postObj, $attr)){
                    $this->$attr=$postObj->$attr;
                }
            }
        }
    }

    /**
     * @return string
     */
    public function response(){
        $response=$this->getResponse();
        $response->Content="您提的问题我们正在处理...";
        return $response->getResponseStr();
    }
    private $_response=false;
    public function getResponse(){
        if($this->_response===false){
            $this->_response=new static();
            $this->_response->ToUserName=$this->FromUserName;
            $this->_response->FromUserName=$this->ToUserName;
            $this->_response->CreateTime=time();
        }
        return $this->_response;
    }
    public function getResponseStr(){
        $attrStr="";
        foreach($this->attributes as $k=>$v){
            if(isset($v)){
                if(in_array($k,self::$ignoreCdata)){
                    $attrStr=$attrStr."<".$k.">".$v."</".$k.">";
                }else{
                    $attrStr=$attrStr."<".$k."><![CDATA[".$v."]]></".$k.">";
                }
            }
        }
        return "<xml>".$attrStr."</xml>";
    }

}