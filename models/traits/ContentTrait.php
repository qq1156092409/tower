<?php

namespace app\models\traits;
/**
 * Class ContentTrait
 * @method loadDefaultValue()
 * @method save()
 * @package app\models\traits
 */
trait ContentTrait {
    public function create(){
        $this->loadDefaultValue();
        return $this->save();
    }
    public function enable(){
        if($this->deleted==0){
            return 2;
        }
        $this->deleted=0;
        if($flag=$this->save()){
            $discuss=$this->discuss and $discuss->enable();
        }
        return $flag?1:0;
    }

    /**
     * @return int 1-success,2-noChange,0-fail
     */
    public function disable(){
        if($this->deleted==1){
            return 2;
        }
        $this->deleted=1;
        if($flag=$this->save()){
            $discuss=$this->discuss and $discuss->disable();
        }
        return $flag?1:0;
    }

    /**
     * @return int 1|0
     */
    public function toggleEnable(){
        return $this->deleted?$this->enable():$this->disable();
    }
} 