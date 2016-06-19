<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "ip".
 *
 * @property integer $id
 * @property string $value
 * @property string $area
 */
class Ip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tower.ip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value', 'area'], 'string', 'max' => 255],
            [['value'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'area' => 'Area',
        ];
    }

    //--method
    public function syncFix(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, Url::to(["/ip/fix","id"=>$this->id],true));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOSIGNAL, true);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1);
        curl_exec($ch);
        curl_close($ch);
    }
}
