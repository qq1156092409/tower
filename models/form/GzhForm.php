<?php

namespace app\models\form;
use yii\base\Model;

class GzhForm extends Model {
    const TEXT="text";
    const IMAGE="image";
    const VOICE="voice";
    const VIDEO="video";
    const SHORT_VIDEO="shortvideo";
    const LOCATION="location";
    const LINK="link";

    public $FromUserName;
    public $ToUserName;
    public $Content;
    public $CreateTime;
    public $MsgType;
    public $FuncFlag;
    public $PicUrl;
    public $MediaId;
    public $Format;
    public $ThumbMediaId;
    public $Recognition;
    public $Location_X;
    public $Location_Y;
    public $Scale;
    public $Label;
    public $Title;
    public $Description;
    public $Url;

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
        $response->Content="您的问题已收到，我们会在第一时间回复您";
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