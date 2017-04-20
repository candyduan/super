<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "simCard".
 *
 * @property integer $id
 * @property string $imsi
 * @property string $imei
 * @property string $iccid
 * @property string $mobile
 * @property integer $provider
 * @property integer $province
 * @property integer $city
 * @property integer $isTest
 * @property string $cmcc
 * @property string $mcc
 * @property string $mnc
 * @property string $lac
 * @property string $cid
 * @property string $model
 * @property integer $osType
 * @property string $os
 * @property integer $sw
 * @property integer $sh
 * @property integer $lastLocateTime
 * @property integer $level
 * @property integer $recordTime
 * @property integer $updateTime
 * @property integer $catTimes
 * @property integer $versionCode
 * @property string $type
 */
class BSimCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'simCard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider', 'province', 'city', 'isTest', 'osType', 'sw', 'sh', 'lastLocateTime', 'level', 'recordTime', 'updateTime', 'catTimes', 'versionCode'], 'integer'],
            [['imsi', 'imei', 'iccid'], 'string', 'max' => 128],
            [['mobile'], 'string', 'max' => 15],
            [['cmcc', 'mcc', 'mnc', 'lac', 'cid', 'type'], 'string', 'max' => 45],
            [['model', 'os'], 'string', 'max' => 100],
            [['imsi'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imsi' => 'Imsi',
            'imei' => 'Imei',
            'iccid' => 'Iccid',
            'mobile' => 'Mobile',
            'provider' => 'Provider',
            'province' => 'Province',
            'city' => 'City',
            'isTest' => 'Is Test',
            'cmcc' => 'Cmcc',
            'mcc' => 'Mcc',
            'mnc' => 'Mnc',
            'lac' => 'Lac',
            'cid' => 'Cid',
            'model' => 'Model',
            'osType' => 'Os Type',
            'os' => 'Os',
            'sw' => 'Sw',
            'sh' => 'Sh',
            'lastLocateTime' => 'Last Locate Time',
            'level' => 'Level',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'catTimes' => 'Cat Times',
            'versionCode' => 'Version Code',
            'type' => 'Type',
        ];
    }
}