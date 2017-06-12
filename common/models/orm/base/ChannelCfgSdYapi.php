<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgSdYapi".
 *
 * @property integer $sdyid
 * @property integer $channelId
 * @property string $spnumberKey1
 * @property string $cmdKey1
 * @property string $sendType1
 * @property string $spnumberKey2
 * @property string $cmdKey2
 * @property string $sendType2
 * @property integer $sendInterval
 * @property string $succKey
 * @property string $succValue
 * @property string $orderIdKey
 * @property string $url
 * @property integer $sendMethod
 * @property integer $respFmt
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 * @property string $delimiter
 */
class ChannelCfgSdYapi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgSdYapi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'sendInterval', 'sendMethod', 'respFmt', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['spnumberKey1', 'cmdKey1', 'spnumberKey2', 'cmdKey2', 'succKey', 'succValue', 'orderIdKey'], 'string', 'max' => 128],
            [['sendType1', 'sendType2'], 'string', 'max' => 256],
            [['url'], 'string', 'max' => 512],
            [['delimiter'], 'string', 'max' => 45],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sdyid' => 'Sdyid',
            'channelId' => 'Channel ID',
            'spnumberKey1' => 'Spnumber Key1',
            'cmdKey1' => 'Cmd Key1',
            'sendType1' => 'Send Type1',
            'spnumberKey2' => 'Spnumber Key2',
            'cmdKey2' => 'Cmd Key2',
            'sendType2' => 'Send Type2',
            'sendInterval' => 'Send Interval',
            'succKey' => 'Succ Key',
            'succValue' => 'Succ Value',
            'orderIdKey' => 'Order Id Key',
            'url' => 'Url',
            'sendMethod' => 'Send Method',
            'respFmt' => 'Resp Fmt',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
            'delimiter' => 'Delimiter',
        ];
    }
}