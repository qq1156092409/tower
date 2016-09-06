<?php

namespace app\components;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\web\View;

/**
 * js文件依赖管理者
 * AssetManager只能管理AssetBundle，这个负责管理单个文件
 * 注意：请先在component中配置再使用
 * Class JsManager
 * @package app\components
 */
class JsManager extends Component{
    const FILE=1;//单个文件
    const BUNDLE=2;//asset-bundle

    /**
     * 通过此方法实例对象
     * @return JsManager
     * @throws InvalidConfigException
     */
    public static function instance(){
        return \Yii::$app->jsManager;
    }

    /** @var View */
    public $view;
    public $default='app\assets\BaseAsset';//所有的js文件都依赖于默认此包，不依赖的也强制引入
    /**
     * @var array
     */
    public $dependence=[
        //plugins
        //js
        "js/yii.simditor.js"=>['app\assets\SimditorAsset',],
        "js/yii.common.js"=>['plugins/jquery.color.js'],
        "js/yii.jqueryUpload.js"=>['app\assets\JqueryFileUploadAsset'],
        //js-model
        "js/models/yii.dir.js"=>['js/yii.common.js'],
        "js/models/yii.discuss.js"=>['js/yii.common.js'],
        "js/models/yii.item.js"=>['js/yii.common.js'],
        "js/models/yii.project.js"=>[
            'js/yii.common.js',
            'app\assets\JqueryUIAsset',
            'js/models/yii.topic.js',
        ],
        "js/models/yii.test.js"=>['js/yii.common.js'],
        "js/models/yii.topic.js"=>['js/yii.common.js'],
        "js/models/yii.file.js"=>[
            'js/yii.common.js',
            'plugins/jquery.tmpl.min.js',
            'app\assets\LightboxAsset',
        ],
        "js/models/yii.userTeam.js"=>['app\assets\JqueryUIAsset'],
        "js/models/yii.subgroup.js"=>['app\assets\JqueryUIAsset'],
    ];
    public $js=[];
    public $temp=[];

    public function init(){
        $this->view=\Yii::$app->view;
    }

    public function register($name){
        if(!isset($this->temp[$name])){
            $this->temp[$name]=false;
            if($depends=$this->getDepends($name,self::FILE)){
                foreach($depends as $depend){
                    $this->register($depend);
                }
            }
            $this->view->registerJsFile('@web/'.$name, ["depends"=>$this->getDepends($name, self::BUNDLE)]);
            $this->temp[$name]=true;
        }elseif($this->temp[$name]===false){
            throw new InvalidConfigException("A circular dependency is detected for js file '$name'.");
        }
    }
    public function registers(array $names){
        foreach($names as $name){
            $this->register($name);
        }
    }

    /**
     * @param $name
     * @param null $type
     * @return array|false
     */
    public function getDepends($name,$type=null){
        $depends=isset($this->dependence[$name])?$this->dependence[$name]:array();
        in_array($this->default,$depends) or $depends[]=$this->default;
        if($depends && $type){
            foreach($depends as $k=>$depend){
                if($this->getType($depend)!=$type){
                    unset($depends[$k]);
                }
            }
        }
        return $depends;
    }
    public function getType($name){
        return substr($name,-3)===".js"?self::FILE:self::BUNDLE;
    }
}