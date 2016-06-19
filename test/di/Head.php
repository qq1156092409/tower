<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16-3-14
 * Time: 上午11:22
 */

namespace app\test\di;


class Head {
    private $_eye;
    private $_nose;
    public function __construct(EyeInterface $eye){
        $this->_eye=$eye;
        $this->_nose=new Nose();
    }
    public function see(){
        $this->_eye->see();
    }
    public function smell(){
        $this->_nose->smell();
    }
} 