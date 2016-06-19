<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property integer $parentID
 * @property string $name
 * @property integer $lft
 * @property integer $rgt
 * @property integer $sort
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentID', 'lft', 'rgt', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentID' => 'Parent ID',
            'name' => 'Name',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'sort' => 'Sort',
        ];
    }

    //--static
    public static function buildTree(){
        $roots=self::findAll(["parentID"=>0]);
        foreach($roots as $root){
            self::build($root);
        }
        return count($roots);
    }
    private static $_number=1;

    /**
     * @param $node Area
     * @return bool
     */
    private static function build($node){
        $node->lft=self::$_number++;
        if($children=$node->getChildren()->orderby("sort,id")->all()){
            foreach($children as $child){
                self::build($child);
            }
        }
        $node->rgt=self::$_number++;
        $node->save();
    }
    //--get
    /**
     * 兄弟
     * @return Dir[]
     */
    public function getSiblings(){
        return self::find()->where(["parentID"=>$this->parentID])->andWhere("id != ".$this->id)->all();
    }

    /**
     * 祖先
     * @return Dir[]
     */
    public function getAncestors(){
        return self::find()->where("lft < ".$this->lft)->andWhere("rgt > ".$this->rgt)->orderBy("lft")->all();
    }

    /**
     * 子孙
     * @return Dir[]
     */
    public function getDescendants(){
        return self::find()->where("lft > ".$this->lft)->andWhere("rgt < ".$this->rgt)->all();
    }
    //--relations
    public function getParent(){
        return $this->hasOne(Area::className(),["id"=>"parentID"]);
    }
    public function getChildren(){
        return $this->hasMany(Area::className(),["parentID"=>"id"]);
    }
}
