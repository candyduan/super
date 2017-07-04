<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgPayParams".
 *
 * @property integer $cppid
 * @property integer $channelId
 * @property string $mobileKey
 * @property string $imeiKey
 * @property string $imsiKey
 * @property string $iccidKey
 * @property string $ipKey
 * @property string $feeKey
 * @property integer $feeUnit
 * @property string $feeCodeKey
 * @property string $feePackages
 * @property string $customs
 * @property string $cpparamKey
 * @property string $cpparamPrefix
 * @property integer $cpparamHandle
 * @property string $provinceMap
 * @property string $provinceMapKey
 * @property string $appNameKey
 * @property string $goodNameKey
 * @property string $provinceNameKey
 * @property string $linkIdKey
 * @property string $timestampKey
 * @property string $unixTimestampKey
 * @property string $signKey
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgPayParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgPayParams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'feeUnit', 'cpparamHandle', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['mobileKey', 'imeiKey', 'imsiKey', 'iccidKey', 'ipKey', 'feeKey', 'feeCodeKey', 'cpparamKey', 'cpparamPrefix', 'provinceMapKey', 'appNameKey', 'goodNameKey', 'provinceNameKey', 'linkIdKey', 'timestampKey', 'unixTimestampKey', 'signKey'], 'string', 'max' => 128],
            [['feePackages'], 'string', 'max' => 512],
            [['customs'], 'string', 'max' => 2048],
            [['provinceMap'], 'string', 'max' => 1024],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cppid' => 'Cppid',
            'channelId' => 'Channel ID',
            'mobileKey' => 'Mobile Key',
            'imeiKey' => 'Imei Key',
            'imsiKey' => 'Imsi Key',
            'iccidKey' => 'Iccid Key',
            'ipKey' => 'Ip Key',
            'feeKey' => 'Fee Key',
            'feeUnit' => 'Fee Unit',
            'feeCodeKey' => 'Fee Code Key',
            'feePackages' => 'Fee Packages',
            'customs' => 'Customs',
            'cpparamKey' => 'Cpparam Key',
            'cpparamPrefix' => 'Cpparam Prefix',
            'cpparamHandle' => 'Cpparam Handle',
            'provinceMap' => 'Province Map',
            'provinceMapKey' => 'Province Map Key',
            'appNameKey' => 'App Name Key',
            'goodNameKey' => 'Good Name Key',
            'provinceNameKey' => 'Province Name Key',
            'linkIdKey' => 'Link Id Key',
            'timestampKey' => 'Timestamp Key',
            'unixTimestampKey' => 'Unix Timestamp Key',
            'signKey' => 'Sign Key',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}