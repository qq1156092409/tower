<?php
namespace app\models\form;

use app\models\Dir;
use app\models\File;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

class DirForm extends Dir{
    const CREATE = "create";
    const EDIT = 'edit';
    const DESTROY = 'destroy';
    const MOVE = 'move';

    public function scenarios(){
        return [
            self::CREATE=>["projectID","parentID","name"],
            self::EDIT=>["id","name"],
            self::DESTROY=>["id"],
        ];
    }
    public function rules(){
        $rules=[
            ["projectID","fixProjectID"],
            [["projectID","parentID","name"],"required"],
        ];
        return array_merge(parent::rules(),$rules);
    }

    public function fixProjectID($attribute,$params){
        if($this->parentID){
            $this->projectID=$this->parent->projectID;
        }
        return true;
    }

    //--cache
    private $_dir=false;
    /**
     * @return Dir
     */
    public function getDir(){
        if($this->_dir===false){
            $this->_dir = Dir::findOne($this->id);
        }
        return $this->_dir;
    }
    public function setDir(Dir $dir){
        $this->_dir=$dir;
        return $this;
    }

    //--action
    public function create($runValidate=true){
        if($runValidate && !$this->validate()) return false;
        $dir=new Dir($this->attributes);
        if($flag=$dir->save()){
            $this->setDir($dir);
        }
        return $dir;
    }
    public function edit($runValidate=true){
        if($runValidate && !$this->validate()) return false;
        $dir=$this->getDir();
        $dir->name=$this->name;
        return $dir->save();
    }

    /**
     * 删除 TODO
     * 删除子文件夹，修改文件
     * @param bool $runValidate
     * @return bool|int
     */
    public function destroy($runValidate=true){
        if($runValidate && !$this->validate()) return false;
        $dir=$this->getDir();
        if($flag=$dir->delete()){
            //effect 把所有文件放在根目录下，删除子文件夹
            $dirs=$dir->getTrees();
            $dirIDs = ArrayHelper::getColumn($dirs, "id");
            File::updateAll(["dirID"=>0,"deleted"=>1],["dirID"=>$dirIDs]);//文件放在根目录下，设置成删除状态，TODO 是否要加operation记录
            Dir::deleteAll("link like '".($this->link.$this->id)."-"."%'");
        }
        return $flag;
    }
    public function move($runValidate=true){
        if($runValidate && !$this->validate()) return false;
        $dir=$this->getDir();
        $oldLink=$dir->link;
        $trees=$dir->getTrees();
        $dir->parentID=$this->parentID;
        if($flag=$dir->save()){
            $newLink=$dir->parentID?($dir->parent->link.$dir->parentID."-"):"-";
            foreach($trees as $one){
                $one->link=strtr($one->link,[$oldLink=>$newLink]);
                $one->save();
            }
        }
        return $flag;
    }


}