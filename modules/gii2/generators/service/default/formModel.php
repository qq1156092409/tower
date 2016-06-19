<?php
/**
 * @var $model \app\modules\gii2\generators\target\Generator
 */
echo '<?php';
?>

namespace app\models\form;

use app\models\<?=ucwords($model->target)?>;

class <?=ucwords($model->target)?>Form extends <?=ucwords($model->target)?> {
    const CREATE = "create";
    const EDIT = "edit";
    const DESTROY = "destroy";
    public function scenarios(){
        //todo finish me
        return [
            "create"=>[],
            "edit"=>[],
            "destroy"=>["id"],
        ];
    }
    public function rules(){
        $rules=[
            ["id","exist"],
        ];
        return array_merge($rules, parent::rules());
    }
    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        $<?=$model->target?>=new <?=ucwords($model->target)?>();
        $<?=$model->target?>->attributes=$this->attributes;
        if($flag=$<?=$model->target?>->save()){
            $this->_<?=$model->target?>=$<?=$model->target?>;
            //create other
        }
        return $flag;
    }
    public function edit($validate=true){
        if($validate && !$this->validate()) return false;
        $<?=$model->target?>=$this->get<?=ucwords($model->target)?>();
        $<?=$model->target?>->load($this->attributes,"");
        return $<?=$model->target?>->save();
    }
    public function destroy($validate=true){
        if($validate && !$this->validate()) return false;
        $<?=$model->target?>=$this->get<?=ucwords($model->target)?>();
        if($flag=$<?=$model->target?>->delete()){
            //delete others
        }
        return $flag;
    }
    public function loadValue(){
        $this->attributes=$this->get<?=ucwords($model->target)?>()->attributes;
    }
    protected $_<?=$model->target?>=false;

    /**
     * @return <?=ucwords($model->target)?>

     * @throws \yii\base\InvalidConfigException
     */
    public function get<?=ucwords($model->target)?>(){
        if($this->_<?=$model->target?>===false){
            $this->_<?=$model->target?> = <?=ucwords($model->target)?>::findOne($this->id);
        }
        return $this->_<?=$model->target?>;
    }
}
