<?php
namespace app\extensions;

use yii\helpers\FileHelper;

class Qrcode extends \QRcode{
    /**
     * 定制默认参数
     * @param $text
     * @param null $outfile
     * @param int $level
     * @param int $size
     * @param int $margin
     * @param bool|false $saveandprint
     * @return string
     */
    public static function png($text, $outfile = null, $level = QR_ECLEVEL_L, $size = 4, $margin = 2, $saveandprint=false){
        if($outfile===null){
            $outfile='qrcode/'.md5($text).".png";//相对路径，相对于入口文件
        }
        $outfile and FileHelper::createDirectory(dirname($outfile));
        parent::png($text, $outfile, $level, $size, $margin, $saveandprint);
        return $outfile;
    }
}