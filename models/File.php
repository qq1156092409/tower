<?php

namespace app\models;

use app\helpers\TimeHelper;
use app\models\multiple\G;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property string $name
 * @property string $temp
 * @property string $extension
 * @property integer $size
 * @property integer $userID
 * @property integer $projectID
 * @property integer $dirID
 * @property integer $version
 * @property integer $deleted
 * @property string $update
 * @property string $create
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size', 'userID', 'projectID', 'dirID', 'version', 'deleted'], 'integer'],
            [['update', 'create'], 'safe'],
            [['name', 'temp'], 'string', 'max' => 256],
            [['extension'],'string','max'=>32],
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
            'temp' => 'Temp',
            'extension' => 'Extension',
            'size' => 'Size',
            'userID' => 'User ID',
            'projectID' => 'Project ID',
            'dirID' => 'Dir ID',
            'version' => 'Version',
            'deleted' => 'Deleted',
            'update' => 'Update',
            'create' => 'Create',
        ];
    }

    //--static
    public static $knowExtensions=['bmp','jpg','jpeg','png','gif','mp3','wav','wma','asf','mp4','avi','rmvb','rm','doc','docx','xls','xlsx','ppt','pptx','zip','rar','7z','cab','iso','txt','pdf','swf','flv'];
    public static $imageExtensions=['bmp','jpg','jpeg','png','gif'];
    //--get
    public function isImage(){
        return in_array($this->extension, self::$imageExtensions);
    }
    public function isKnow(){
        return in_array($this->extension, self::$knowExtensions);
    }
    public function preview(){
        if($this->isImage()){
//            $temp="temp/".$this->temp;
//            copy("../files/".$this->temp,$temp);//复制到temp目录下供临时预览
//            return Url::to($temp);//todo 那种方式好？
            return Url::to(["/file/download", "id" => $this->id]);
        }elseif($this->isKnow()){
            return Url::to("public/file_icons/file_extension_".$this->extension.".png");
        }else{
            return Url::to("public/file_icons/file_extension_others.png");
        }
    }
    public function size(){
        return Yii::$app->formatter->asSize($this->size);
    }
    public function getLastOperation(){
        return $this->hasOne(Operation::className(), ["value" => "id"])->onCondition("model=".G::FILE)->orderBy("id desc");
    }
    /**
     * 获取文件目录
     * @return Dir[]
     */
    public function getDirs(){
        $dirs=[];
        if($this->dir){
            $dirs=$this->dir->parents;
            $dirs[]=$this->dir;
        }
        return $dirs;
    }
    public function getFuzzyCreate(){
        return TimeHelper::getFuzzyTime($this->create);
    }
    public function getFuzzyUpdate(){
        return TimeHelper::getFuzzyTime($this->update);
    }
    public function getViewUrl(){
        return Url::to(["/file","id"=>$this->id]);
    }
    public function getDisableUrl(){
        return Url::to(["/file/disable", "id" => $this->id]);
    }
    public function getTeamID(){
        return $this->project->teamID;
    }
    //--relation
    public function getProject(){
        return $this->hasOne(Project::className(), ["id" => "projectID"]);
    }
    public function getOperations(){
        return $this->hasMany(Operation::className(), ["value" => "id"])->onCondition("model=".G::FILE);
    }
    public function getDir(){
        return $this->hasOne(Dir::className(),["id"=>"dirID"]);
    }
    public function getUser(){
        return $this->hasOne(User::className(),["id"=>"userID"]);
    }
    public function getRelevance(){
        return $this->hasOne(Relevance::className(),["value"=>"id"])->onCondition("model =" . G::FILE);
    }
    public function getDiscuss(){
        return $this->hasOne(Discuss::className(),["value"=>"id"])->onCondition("model =" . G::FILE);
    }
}
