<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgSmtParams".
 *
 * @property integer $cspid
 * @property integer $channelId
 * @property string $orderIdKey
 * @property string $verifyCodeKey
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 * @property string $feeKey
 * @property integer $feeUnit
 * @property string $customs
 * @property string $mobileKey
 * @property string $cpparamKey
 * @property string $imeiKey
 * @property string $imsiKey
 * @property string $iccidKey
 * @property string $ipKey
 * @property string $signKey
 * @property string $smsContentKey
 * @property string $smsNumberKey
 * @property string $timestampKey
 * @property string $unixTimestampKey
 */
class ChannelCfgSmtParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgSmtParams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'status', 'feeUnit'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['orderIdKey', 'verifyCodeKey', 'feeKey', 'customs', 'mobileKey', 'cpparamKey', 'imeiKey', 'imsiKey', 'iccidKey', 'ipKey', 'signKey', 'smsContentKey', 'smsNumberKey', 'timestampKey', 'unixTimestampKey'], 'string', 'max' => 128],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cspid' => 'Cspid',
            'channelId' => 'Channel ID',
            'orderIdKey' => 'Order Id Key',
            'verifyCodeKey' => 'Verify Code Key',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
            'feeKey' => 'Fee Key',
            'feeUnit' => 'Fee Unit',
            'customs' => 'Customs',
            'mobileKey' => 'Mobile Key',
            'cpparamKey' => 'Cpparam Key',
            'imeiKey' => 'Imei Key',
            'imsiKey' => 'Imsi Key',
            'iccidKey' => 'Iccid Key',
            'ipKey' => 'Ip Key',
            'signKey' => 'Sign Key',
            'smsContentKey' => 'Sms Content Key',
            'smsNumberKey' => 'Sms Number Key',
            'timestampKey' => 'Timestamp Key',
            'unixTimestampKey' => 'Unix Timestamp Key',
        ];
    }
}