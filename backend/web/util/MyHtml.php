<?php
namespace backend\web\util;

class MyHtml
{
    public static function br() {
        return '</br>';
    }

    public static function emptyString () {
        return '   ';
    }

    public static function iElement($class,$clickMethod, $clickMethodParameters){
        return '<i class=" pointer ' . $class . '", onclick="' . $clickMethod. '(' . $clickMethodParameters . ');"></i>';
    }

    public static function iElements($clickMethod, $clickMethodParameters,$blue,$green,$black,$purple){
        return '<i class="glyphicon pointer ' .$blue. ' glyphicon-off" onclick="' . $clickMethod. '(' . $clickMethodParameters . ');"></i> '.
               ' <i class="glyphicon pointer ' .$green.' glyphicon-ok-sign", onclick="' . $clickMethod. '(' . $clickMethodParameters . ');"></i> '.
               ' <i class="glyphicon pointer '.$black.' glyphicon-trash", onclick="' . $clickMethod. '(' . $clickMethodParameters . ');"></i> '.
               ' <i class="glyphicon pointer ' .$purple.' glyphicon-wrench", onclick="' . $clickMethod. '(' . $clickMethodParameters . ');"></i>';
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
}