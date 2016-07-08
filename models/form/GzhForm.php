<?php

namespace app\models\form;
use app\extensions\gzh\GzhHandler;
use yii\base\Model;

class GzhForm extends Model {
    //msg type
    const TEXT="text";
    const IMAGE="image";
    const VOICE="voice";
    const VIDEO="video";
    const SHORT_VIDEO="shortvideo";
    const LOCATION="location";
    const LINK="link";
    const EVENT="event";

    //event type
    const EVENT_SUBSCRIBE="subscribe";
    const EVENT_UN_SUBSCRIBE="unsubscribe";
    const EVENT_SCAN="SCAN";
    const EVENT_LOCATION="LOCATION";
    const EVENT_CLICK="CLICK";
    const EVENT_VIEW="VIEW";

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
    public $Event;
    public $EventKey;
    public $Ticket;
    public $Latitude;
    public $Longitude;
    public $Precision;

    public static $ignoreCdata=array(
        "FuncFlag",
        "CreateTime",
        "FuncFlag",
    );

    public function receive(){
        $postStr=$GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr=' <xml>
 <ToUserName><![CDATA[toUser]]></ToUserName>
 <FromUserName><![CDATA[fromUser]]></FromUserName>
 <CreateTime>1348831860</CreateTime>
 <MsgType><![CDATA[text]]></MsgType>
 <Content><![CDATA[this is a test]]></Content>
 <MsgId>1234567890123456</MsgId>
 </xml>';
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
        $handler=new GzhHandler();
        $handler->model=$this;
        return $handler->handle();
    }

    /**
     * @var static|GzhForm
     */
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
    public function toXml(){
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