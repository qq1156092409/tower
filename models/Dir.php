<?php

namespace app\models;

use app\models\multiple\G;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "dir".
 *
 * @property integer $id
 * @property string $name
 * @property integer $projectID
 * @property integer $parentID
 * @property string $link
 * @property integer $packed
 * @property string $update
 */
class Dir extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.dir';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectID', 'parentID', 'packed'], 'integer'],
            [['update'], 'safe'],
            [['name', 'link'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'projectID' => 'Project ID',
            'parentID' => 'Parent ID',
            'link' => 'Link',
            'packed' => 'Packed',
            'update' => 'Update',
        ];
    }

    //--action
//    public static function create($attributes){
//        $dir=new Dir();
//        $dir->load($attributes,"");
//        $dir->projectID or $dir->projectID=$dir->parent->projectID;
//        $dir->update=date("Y-m-d H:i:s");
//        return $dir->save()?$dir:false;
//    }
    /**
     * 递归子对象
     * @param $current
     * @param $list
     */
//    private static function recursionChildren($current,&$list){
//        if(0 < count($current->children)){
//            foreach($current->children as $child){
//                $list[]=$child;
//                self::recursionChildren($child, $list);
//            }
//        }
//    }
//    public function reName($name){
//        $this->name=$name;
//        $this->update=date("Y-m-d H:i:s");
//        return $this->save();
//    }
    /**
     * 移动
     * 不能移动到自己和自己的子孙
     * @param $parentID int|0
     * @return int
     *      1   成功
     *      0   未移动
     *      -1  失败
     */
//    public function move($parentID){
//        if($this->parentID ==$parentID){
//            return 0;
//        }
//        $noIDs=ArrayHelper::getColumn($this->getTrees(), "id");
//        if(in_array($parentID,$noIDs)){
//            return -1;
//        }
//        $to = self::findOne($parentID);
//        $this->parentID=$parentID;
//        $to and $this->projectID=$to->projectID;
//        $this->update=date("Y-m-d H:i:s");
//        return $this->save()?1:-1;
//    }
    /**
     * 删除本文件夹和子文件夹
     * 内所有文件设成不可用，并移动到根目录下
     * @return bool
     */
//    public function destroy(){
//        if($flag=$this->delete()){
//            //删除子文件夹
//            $dirIDs=ArrayHelper::getColumn($this->allChildren, "id");
//            $dirIDs and Dir::deleteAll(["id" => $dirIDs]);
//            //文件处理
//            $fileIDs=ArrayHelper::getColumn($this->getAllFiles(), "id");
//            $fileIDs and File::updateAll(["deleted"=>G::DELETED,"dirID"=>0],[
//                "id"=>$fileIDs
//            ]);
//        }
//        return $flag?true:false;
//    }

    const PACKAGE_PATH_ALIAS="@app/files/dir";//包裹路径别名

    /**
     * @return bool
     */
    public function pack(){
        if($this->packed) return true;
        $zip=new \ZipArchive();
        $filePath=$this->getFilePath();
        FileHelper::createDirectory(dirname($filePath));
        if($zip->open($filePath,file_exists($filePath)?\ZipArchive::OVERWRITE:\ZipArchive::CREATE)===true){
            $names=[];
            foreach($this->getAllFiles() as $file){
                $zip->addFile('../files/'.$file->temp,$this->getRelativePath($this,$file,$names));
            }
            $this->packed=1;
            return $this->save();
        }
        return false;
    }

    /**
     * @param $compare Dir
     * @param $file File
     * @return string
     */
    protected function getRelativePath($compare,$file,&$names){
        $dir=$file->dir;
        $path = $file->name;
        while($dir->id!=$compare->id){
            $path=$dir->name."/".$path;
            $dir=$dir->parent;
        }
        if($names[$path]){
            //名字冲突 a/b/c.txt => a/b/c_x.txt
            $names[$path]++;
            $ext = pathinfo($file->name, PATHINFO_EXTENSION);
            if($ext){
                $temp=substr($path,0,strlen($path)-strlen($ext)-1);
                $path=$temp.("_".($names[$path]-1).".".$ext);
            }else{
                $path.=("_".$names[$path]);
            }
        }else{
            $names[$path]=1;
        }
        return $path;
    }
    /**
     * 获取文件路径
     * @return string
     */
    public function getFilePath(){
        return FileHelper::normalizePath(Yii::getAlias(self::PACKAGE_PATH_ALIAS."/".$this->id.".zip"));
    }
    public function beforeSave($insert){
        if ($flag=parent::beforeSave($insert)) {
            if($insert){
                $this->loadDefaultValues();
                $this->update=date("Y-m-d H:i:s");
                //fix link
                if($this->parentID){
                    $this->link = $this->parent->link . $this->parentID . "-";
                }else{
                    $this->link = "-";
                }
            }
        }
        return $flag;
    }

    //--get
    /**
     * 文件夹+子文件夹下所有文件
     * @return File[]
     */
    public function getAllFiles(){
        $dirs=$this->getTrees();
        $dirIDs = ArrayHelper::getColumn($dirs, "id");
        return File::find()->where([
            "projectID"=>$this->projectID,
            "dirID"=>$dirIDs,
        ])->all();
    }
    public function getIsEmpty(){
        $dirs=$this->getTrees();
        $dirIDs = ArrayHelper::getColumn($dirs, "id");
        return !File::find()->where(["dirID"=>$dirIDs,"deleted"=>0])->exists();
    }
    /**
     * 树，（自己+子孙后代）
     * @return Dir[]
     */
    public function getTrees(){
        $trees=[$this];
        $trees=array_merge($trees, $this->getDescendants());
        return $trees;
    }

    /**
     * 兄弟
     * @return Dir[]
     */
    public function getSiblings(){
        return Dir::find()->where(["parentID"=>$this->parentID])->andWhere("id != ".$this->id)->all();
    }

    /**
     * 祖先
     * @return Dir[]
     */
    public function getAncestors(){
        $arr=[];
        $parentIDs = explode("-",$this->link);
        $parentIDs=array_filter($parentIDs);
        if($parentIDs){
            $parents = Dir::find()->where(["id"=>$parentIDs])->indexBy("id")->all();
            foreach($parentIDs as $id){
                $arr[] = $parents[$id];
            }
        }
        return $arr;
    }

    /**
     * 子孙
     * @return Dir[]
     */
    public function getDescendants(){
        return Dir::find()->where("link like '".($this->link.$this->id)."-"."%'")->all();
    }
    //--relation
    public function getParent(){
        return $this->hasOne(self::className(),["id"=>"parentID"]);
    }
    public function getChildren(){
        return $this->hasMany(self::className(), ["parentID" => "id"]);
    }
    public function getProject(){
        return $this->hasOne(Project::className(), ["id" => "projectID"]);
    }
}
