<?php
namespace backend\web\util;

use common\library\Utils;

class MyHtml
{
    public static function br() {
        return '</br>';
    }

    public static function emptyString () {
        return '   ';
    }

    public static function iElement($class,$clickMethod, $clickMethodParameters, $caid ='',$id = ''){
        $idStr = "";
        if(Utils::isValid($id)){
            $idStr = ' id="'.$id.'" ';
        }
        if($clickMethod !== ''){
            return '<i title="' . $caid . '" class=" pointer ' . $class . '" onclick="' . $clickMethod . '(' . $clickMethodParameters . ');"' . $idStr . '></i>';
        }else{
            return '<i title="' . $caid . '" class=" pointer ' . $class . '" ' . $idStr . '></i>';
        }
    }
    //0-无效，1-暂停，2-测试，3-运行
    public static function iElements($clickMethod, $clickMethodParameters,$blue,$green,$black,$purple){
        return '<i title = "暂停" class="glyphicon pointer ' .$blue. ' glyphicon-circle-arrow-right" onclick="' . $clickMethod. '(' . $clickMethodParameters . ',1);"></i> '.
               ' <i title = "运行" class="glyphicon pointer ' .$green.' glyphicon-ok-sign" onclick="' . $clickMethod. '(' . $clickMethodParameters . ',3);"></i> '.
               ' <i title = "删除" class="glyphicon pointer '.$black.' glyphicon-trash" onclick="' . $clickMethod. '(' . $clickMethodParameters . ',0);"></i> '.
               ' <i title = "测试" class="glyphicon pointer ' .$purple.' glyphicon-wrench" onclick="' . $clickMethod. '(' . $clickMethodParameters . ',2);"></i>';
    }

    public static function doubleiElements($clickMethod1, $clickMethod2, $clickMethodParameters1, $clickMethodParameters2, $blue,$green){
        return '<i class="glyphicon pointer ' .$blue. ' glyphicon-off" onclick="' . $clickMethod1. '(' . $clickMethodParameters1 . ');"></i> '.
            ' <i class="glyphicon pointer ' .$green. ' glyphicon-ok-sign" onclick="' . $clickMethod2. '(' . $clickMethodParameters2 . ');"></i> ';
    }

    public static function aElement($href, $clickMethod, $clickMethodParameters, $text) {
        if ($clickMethod != '') {
            return '<a class="pointer" href="' . $href . '" onclick="' . $clickMethod. '(' . $clickMethodParameters . ');">' .$text . '</a>';
        } else {
            return '<a class="pointer"href="' . $href . '" >' .$text . '</a>';
        }
    }


    public static function aElements($href, $clickMethod, $clickMethodParameters, $text) {
        if ($clickMethod != '') {
            return "<a class=\"pointer\" href='" . $href . "' onclick='" . $clickMethod. "(" . $clickMethodParameters .");'>" .$text . "</a>";
        } else {
            return '<a class="pointer"  href="' . $href . '" >' .$text . '</a>';
        }
    }

    public static function imgElement($src, $class = 'thumbnail gclass_img_width_md') {
        if ($src != '') {
            return '<img src="' . $src . '" ' . ($class !== '' ? 'class="' . $class . '"' : '') . ' />';
        } else {
            return '';
        }
    }

    public static function imgElementWithFunction($src, $class = 'thumbnail gclass_img_width_md', $func) {
        if ($src != '') {
            return '<img src="' . $src . '" ' . ($class !== '' ? 'class="' . $class . '"' : '') . ($func !== '' ? 'onclick="' . $func . '"' : ''). ' />';
        } else {
            return '';
        }
    }

    public static function aElementBlank($href, $clickMethod, $clickMethodParameters, $text) {
        if ($clickMethod != '') {
            return '<a href="' . $href . '" onclick="' . $clickMethod. '(' . $clickMethodParameters . '); target="_blank"">' .$text . '</a>';
        } else {
            return '<a href="' . $href . '"   target="_blank"">' .$text . '</a>';
        }
    }

    public static function inputWeightElement($value, $id, $onChangeMethod) {
        return '<input type="text" value="' . $value . '" id="' . $id .
            '" onchange="' . $onChangeMethod . '(this.id);" class="text-center"/>';
    }
    public static function inputElement($value, $id, $onChangeMethod,$changeMethodParameters) {
        if ($onChangeMethod != '') {
            return '<input class="form-control" type="text" value="' . $value . '" title="'.$value.'" id="' . $id .
            '" onchange="' . $onChangeMethod . '(' .$changeMethodParameters. ');" />';
        } else {
            return '<input class="form-control" type="text" value="' . $value . '" title="'.$value.'" id="' . $id .
            '"/>';
        }
    }
}