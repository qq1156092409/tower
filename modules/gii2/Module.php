<?php

namespace app\modules\gii2;

class Module extends \yii\gii\Module
{
    public $controllerNamespace = 'app\modules\gii2\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * Returns the list of the core code generator configurations.
     * @return array the list of the core code generator configurations.
     */
    protected function coreGenerators()
    {
        return array_merge(parent::coreGenerators(),[
            'service' => ['class' => 'app\modules\gii2\generators\service\Generator'],
        ]);
    }

}
