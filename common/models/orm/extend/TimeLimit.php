<?php
namespace common\models\orm\extend;
class TimeLimit extends \common\models\orm\base\TimeLimit{
    public static function getItemArrByChid($chid){
        $item   = array(
            'chid'      => $chid,
            'h0'        => 0,
            'h1'        => 0,
            'h2'        => 0,
            'h3'        => 0,
            'h4'        => 0,
            'h5'        => 0,
            'h6'        => 0,
            'h7'        => 0,
            'h8'        => 0,
            'h9'        => 0,
            'h10'       => 0,
            'h11'       => 0,
            'h12'       => 0,
            'h13'       => 0,
            'h14'       => 0,
            'h15'       => 0,
            'h16'       => 0,
            'h17'       => 0,
            'h18'       => 0,
            'h19'       => 0,
            'h20'       => 0,
            'h21'       => 0,
            'h22'       => 0,
            'h23'       => 0,
        );
        $model  = self::findByChid($chid);
        if($model){
            $item   = array(
                'chid'      => $model->channel,
                'h0'        => $model->h0,
                'h1'        => $model->h1,
                'h2'        => $model->h2,
                'h3'        => $model->h3,
                'h4'        => $model->h4,
                'h5'        => $model->h5,
                'h6'        => $model->h6,
                'h7'        => $model->h7,
                'h8'        => $model->h8,
                'h9'        => $model->h9,
                'h10'       => $model->h10,
                'h11'       => $model->h11,
                'h12'       => $model->h12,
                'h13'       => $model->h13,
                'h14'       => $model->h14,
                'h15'       => $model->h15,
                'h16'       => $model->h16,
                'h17'       => $model->h17,
                'h18'       => $model->h18,
                'h19'       => $model->h19,
                'h20'       => $model->h20,
                'h21'       => $model->h21,
                'h22'       => $model->h22,
                'h23'       => $model->h23,
            );
        }
        return $item;
    }
    
    public static function findByChid($chid){
        $condition  = array(
            'channel'   => $chid,
        );
        $model  = self::find()
                        ->where($condition)
                        ->one()
                        ;
        return $model;
    }
}
