<?php

namespace app\extensions;
use app\vendor\gateway\Gateway;

class GatewayHelper{
    const CLIENT=1;
    const USER=2;
    const GROUP=3;

    /**
     * @param $message
     * @param null|int $target
     * @param null|array $values
     */
    public static function send($message,$target=null,$values=null){
        if($target && $values){
            if($target==self::CLIENT){
                Gateway::sendToAll($message, $values);
            }elseif($target==self::USER){
                Gateway::sendToUid($values,$message);
            }elseif($target==self::GROUP){
                Gateway::sendToGroup($values, $message);
            }
        }else{
            Gateway::sendToAll($message);
        }
    }
}