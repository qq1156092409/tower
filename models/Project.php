<?php

namespace app\models;

use app\models\multiple\G;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $icon
 * @property string $description
 * @property integer $teamID
 * @property integer $iconColor
 * @property string $create
 * @property integer $template
 * @property string $section
 * @property integer $archive
 * @property integer $sort
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'teamID'], 'required'],
            [['type', 'icon', 'teamID', 'iconColor', 'template','archive','sort'], 'integer'],
            [['create'], 'safe'],
            [['name', 'description', 'section'], 'string', 'max' => 256]
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
            'type' => 'Type',
            'icon' => 'Icon',
            'description' => 'Description',
            'teamID' => 'Team ID',
            'iconColor' => 'Icon Color',
            'create' => 'Create',
            'template' => 'Template',
            'section' => 'Section',
            'archive' => 'Archive',
            'sort' => 'Sort',
        ];
    }

    //--attribute
    const STANDARD=1;//标准
    const BOARD=2;//看板
    const SAMPLE=3;//示例

    //--event
    public function beforeSave($insert){
        if($flag = parent::beforeSave($insert)){
            $insert and $this->loadDefaultValues();
        }
        return $flag;
    }
    public function loadDefaultValues($skipIfSet = true){
        $this->section or $this->section=self::getDefaultSection();
        $this->icon or $this->icon = rand(1, 8);
        $this->iconColor or $this->iconColor=rand(1,25);
        $this->create or $this->create=date("Y-m-d H:i:s");
        return parent::loadDefaultValues($skipIfSet);
    }

    //--get
    public function getViewUrl(){
        return Url::to(["/project","id"=>$this->id]);
    }
    public function getEvents(){
        return $this->calendar->events;
    }
    public function getTeamID(){
        return $this->teamID;
    }
    public function getMemberCount(){
        return UserProject::find()->where(["projectID"=>$this->id])->count();
    }
    public static function getDefaultSection(){
        return implode("-", [G::TASK]);
    }
    public static function getAllSectionIDs(){
        return [G::DISCUSS, G::TASK , G::FILE , G::DOC, G::EVENT];
    }
    public function getSectionIDs(){
        if(!$this->section){
            return [];
        }
        return explode("-",$this->section);
    }
    public function getMissSectionIDs(){
        return array_diff(self::getAllSectionIDs(), $this->getSectionIDs());
    }
    public function hasSection($id){
        return in_array($id, $this->getSectionIDs());
    }
    public function getLastOperation($type=null){
        $where=[
            "model"=>G::PROJECT,
            "value"=>$this->id,
        ];
        $type and $where["type"]=$type;
        return Operation::find()->where($where)->orderBy("id desc")->one();
    }
    public function getCommonItems(){
        return $this->getItems()->onCondition("item.deleted = 0 and item.archive = 0 ");//常见清单，未归档，未删除
    }
    //--relation
    public function getItems(){
        return $this->hasMany(Item::className(), ["projectID" => "id"])->inverseOf('project');
    }
    public function getDirectItem(){
        return $this->hasOne(Item::className(),["projectID"=>"id"])->onCondition("item.type = ".Item::PROJECT_DIRECT);
    }
    public function getDirs(){
        return $this->hasMany(Dir::className(), ["projectID" => "id"])->inverseOf('project');
    }
    public function getTasks(){
        return $this->hasMany(Task::className(), ["projectID" => "id"])->inverseOf("project");
    }
    public function getCommonTasks(){
        return $this->getTasks()->onCondition("deleted = 0 and status != ".Task::FINISHED);//常见任务，未完成，未删除
    }
    public function getTeam(){
        return $this->hasOne(Team::className(), ["id" => "teamID"]);
    }
    public function getCalendar(){
        return $this->hasOne(Calendar::className(),["projectID"=>"id"]);
    }
    public function getUserProjects(){
        return $this->hasMany(UserProject::className(), ["projectID" => "id"]);
    }
    public function getRelevance(){
        return $this->hasOne(Relevance::className(), ["value" => "id"])->onCondition("model = ".G::PROJECT);
    }
}
