<?php
namespace common\models\orm\extend;
class AdminAuthor extends \common\models\orm\base\AdminAuthor{
    public static function findByAuidPower($auid,$power){
        $model  = self::find()
                    ->where(['like','power', $power])
                    ->andWhere(['=','auid',$auid])
                    ->one()
                    ;
        return $model;
    }

    public static function getPowersByAuid($auid){
        $data  = self::find()
            ->where(['=','auid',$auid])
            ->andwhere(['=','status',1])->orderBy('aaid')
            ->all();
        $return_data = [];
        foreach($data as $value){
            $return_data[] = $value['power'];
        }
        return $return_data;
    }
}
