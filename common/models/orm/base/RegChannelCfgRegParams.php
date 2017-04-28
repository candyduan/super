<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgRegParams".
 *
 * @property integer $crpid
 * @property integer $rcid
 * @property string $mobileKey
 * @property string $imeiKey
 * @property string $imsiKey
 * @property string $iccidKey
 * @property string $ipKey
 * @property string $customs
 * @property string $cpparamKey
 * @property string $cpparamPrefix
 * @property string $provinceMap
 * @property string $provinceMapKey
 * @property string $provinceNameKey
 * @property string $linkIdKey
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelCfgRegParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelCfgRegParams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcid'], 'required'],
            [['rcid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['mobileKey', 'imeiKey', 'imsiKey', 'iccidKey', 'ipKey', 'cpparamKey', 'cpparamPrefix', 'provinceMapKey', 'provinceNameKey', 'linkIdKey'], 'string', 'max' => 128],
            [['customs'], 'string', 'max' => 512],
            [['provinceMap'], 'string', 'max' => 1024],
            [['rcid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'crpid' => 'Crpid',
            'rcid' => 'Rcid',
            'mobileKey' => 'Mobile Key',
            'imeiKey' => 'Imei Key',
            'imsiKey' => 'Imsi Key',
            'iccidKey' => 'Iccid Key',
            'ipKey' => 'Ip Key',
            'customs' => 'Customs',
            'cpparamKey' => 'Cpparam Key',
            'cpparamPrefix' => 'Cpparam Prefix',
            'provinceMap' => 'Province Map',
            'provinceMapKey' => 'Province Map Key',
            'provinceNameKey' => 'Province Name Key',
            'linkIdKey' => 'Link Id Key',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
