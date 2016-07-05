<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/7/5
 * Time: 20:48
 */

namespace app\models\form;


use yii\base\Model;

class GzhForm extends Model {
    public $signature;
    public $timestamp;
    public $nonce;
    public $echostr;

    private $_token="weixin";

    public function valid(){

    }

}