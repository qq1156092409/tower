<?php

namespace app\models\form;

use app\models\Dir;
use app\models\File;
use app\models\Operation;
use app\models\multiple\G;
use app\models\UserTeam;
use yii\helpers\Security;
use yii\web\UploadedFile;

class FileForm extends File{
    const CREATE = "create";
    const TOGGLE_ENABLE = "toggleEnable";
    const MOVE = "move";
    const UPLOAD = "upload";

    /** @var  UploadedFile */
    public $attachment;

    public function preprocess(){
        if($this->dirID){
            $dir=Dir::findOne($this->dirID);
            $dir and $this->projectID=$dir->projectID;
        }
    }
    public function scenarios(){
        return [
            self::CREATE=>["projectID","name","temp"],
            self::TOGGLE_ENABLE=>["id"],
            self::MOVE=>["id","dirID"],
            self::UPLOAD=>["projectID","dirID","attachment"],
        ];
    }
    public function rules(){
        $rules=[
            ["id","exist"],
            ["id","checkID"],
            ["dirID","checkDirID","on"=>[self::MOVE]],
        ];
        return array_merge($rules, parent::rules());
    }
    public function checkID($attribute,$params){
        if($this->id){
            $file=$this->getFile();
            if(!$file){
                $this->addError($attribute, "请求的内容未找到");return;
            }
            $userTeam = UserTeam::findOne(["userID" => \Yii::$app->user->id, "teamID" => $file->project->teamID]);
            if(!$userTeam){
                $this->addError($attribute, "你不是我们机组的吧");return;
            }
        }
    }
    public function checkDirID($attribute,$params){
        if($this->dirID){
            $dir=Dir::findOne($this->dirID);
            if(!$dir){
                $this->addError($attribute, "请求的内容未找到");return;
            }
            if($dir->projectID!=$this->getFile()->projectID){
                $this->addError($attribute, "你不是我们机组的吧");return;
            }
        }
    }
    public function create($validate=true){
        if($validate && !$this->validate()) return false;
        $file=new File();
        $file->load($this->attributes,"");
        $file->create=$file->update=date("Y-m-d H:i:s");
        if($flag=$file->save()){
            $this->_file=$file;
            $this->createOperation(Operation::ADD);
        }
        return $flag;
    }
    public function toggleEnable($validate=true){
        if($validate && !$this->validate()) return false;
        $file=$this->getFile();
        $file->deleted=($file->deleted+1)%2;
        if($flag=$file->save()){
            $this->createOperation($file->deleted?Operation::DISABLE:Operation::ENABLE);
            $this->syncDiscuss();
        }
        return $flag;
    }
    public function move($validate=true){
        if($validate && !$this->validate()) return false;
        $file=$this->getFile();
        $file->dirID=$this->dirID;
        $file->update=date("Y-m-d H:i:s");
        if($flag=$file->save()){
            $this->createOperation(Operation::MOVE);
        }
        return $flag;
    }
    public function upload($validate=true){
        if($validate && !$this->validate()) return false;
        $temp=$this->saveAttachment();
        $file=new File();
        $file->temp=$temp;
        $file->dirID=$this->dirID?:0;
        $file->projectID=$this->projectID;
        $file->userID=\Yii::$app->user->id;
        $file->version=1;
        $file->deleted=0;
        $file->size=$this->attachment->size;
        $file->extension=$this->attachment->extension;
        $file->create=date("Y-m-d H:i:s");
        $file->update=$file->create;
        $file->name=$this->attachment->name;
        if($flag=$file->save()){
            $this->_file=$file;
            $this->createOperation(Operation::ADD);
        }
        return $flag;
    }
    private function saveAttachment(){
        $file=Security::generateRandomKey().".".$this->attachment->getExtension();
        $this->attachment->saveAs("../files/".$file);
        return $file;
    }
    private function createOperation($type){
        $textMap=[
            Operation::ADD=>"上传了文件",
            Operation::DISABLE=>"删除了文件",
            Operation::ENABLE=>"恢复了文件",
            Operation::MOVE=>"移动了文件",
        ];
        return Operation::create([
            'userID' =>\Yii::$app->user->id,
            'type' => $type,
            'text' => $textMap[$type],
            'value' => $this->id,
            'model' => G::FILE,
        ]);
    }
    private function syncDiscuss(){
        $file=$this->getFile();
        if($discuss=$file->discuss){
            $discuss->deleted=$file->deleted;
            return $discuss->save();
        }
        return true;
    }

    private $_file=false;

    /**
     * @return File
     */
    public function getFile(){
        if($this->_file===false){
            $this->_file = File::findOne($this->id);
        }
        return $this->_file;
    }
} 