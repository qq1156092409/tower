<?php

namespace app\extensions;
use PHPExcel_Worksheet;
use PHPExcel_Cell;
use PHPExcel_IOFactory;
use PHPExcel;

/**
 * 几个常用的方法
 * Class ExcelHelper
 * @package app\extensions
 */
class ExcelHelper {
    private static $types=[
        "xls"=>"Excel5",
        "xlsx"=>"Excel2007",
    ];

    /**
     * @param $file
     * @return string
     */
    public static function getType($file){
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        return self::$types[strtolower($ext)];
    }
    /**
     * @param $sheet PHPExcel_Worksheet
     * @return array 2维数组，键名从0开始
     */
    public static function getValues($sheet){
        $width = $sheet->getHighestColumn();
        $width= PHPExcel_Cell::columnIndexFromString($width);
        $high = $sheet->getHighestRow();
        $data=[];
        for ($y = 1; $y <= $high; $y++) {
            for ($x = 1; $x <= $width; $x++){
                $data[$y-1][$x-1]=$sheet->getCellByColumnAndRow($x-1, $y)->getValue();
            }
        }
        return $data;
    }

    /**
     * @param $sheet PHPExcel_Worksheet
     * @param $values array[] 2维数组，键名从0开始
     * @return bool
     */
    public static function setValues($sheet,$values){
        foreach($values as $y=>$rows){
            foreach($rows as $x=>$value){
                $sheet->setCellValueByColumnAndRow($x, $y+1, $value);
            }
        }
        return true;
    }

    /**
     * 读取第一个sheet的内容
     * 若要读取多个sheet，请使用原生的方法
     * @param $url
     * @return array
     */
    public static function read($url){
        $excel=PHPExcel_IOFactory::createReaderForFile(basename($url))->load($url);
        $sheet = $excel->getSheet();
        return self::getValues($sheet);
    }

    /**
     * @param $url
     * @param $values array 2维数组，键名从0开始
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public static function write($url,$values){
        $type=self::getType($url)?:"Excel2007";
        $excel=new PHPExcel();
        self::setValues($excel->getSheet(), $values);
        $writer=PHPExcel_IOFactory::createWriter($excel,$type);
        $writer->save($url);
    }
}