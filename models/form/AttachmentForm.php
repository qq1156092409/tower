<?php
namespace app\models\form;

use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\Security;
use yii\web\UploadedFile;

class AttachmentForm extends Model{
    const SINGLE = "single";
    const MULTIPLE = "multiple";
    const SIMDITOR = "simditor";

    public $file;
    public $files=[];

    public function scenarios(){
        return [
            self::SINGLE=>["file"],
            self::MULTIPLE=>["files"],
            self::SIMDITOR=>["file"],
        ];
    }

    public function rules(){
        return [
            [["file","files"],"required"],
            ["file","file","types"=>["bmp","jpg","jpeg","png","gif","eif"]],
            ["files","safe"],//todo
            ["file","file","types"=>["bmp","jpg","jpeg","png","gif"],"on"=>self::SIMDITOR],
        ];
    }
    public function upload($validate=true){
        if($validate && !$this->validate()) return false;
        $count=0;
        FileHelper::createDirectory("temp");
        /** @var UploadedFile[] $files */
        $files=array_merge([],$this->files,[$this->file]);
        if($files){
            foreach($files as $file){
                $path="temp/" . Security::generateRandomKey().".".$file->getExtension();
                if($file->saveAs($path)){
                    $count++;
                    $this->_paths[]=$path;
                }
            }
        }
        return $count;
    }
    private $_paths=[];
    public function getPaths(){
        return $this->_paths;
    }
    public function getPath(){
        return $this->_paths[0];
    }

}