<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgSmsYapi".
 *
 * @property integer $csyid
 * @property integer $rcid
 * @property string $spnumberKey1
 * @property string $cmdKey1
 * @property integer $sendType1
 * @property string $spnumberKey2
 * @property string $cmdKey2
 * @property integer $sendType2
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
 */
class RegChannelCfgSmsYapi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelCfgSmsYapi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcid'], 'required'],
            [['rcid', 'sendType1', 'sendType2', 'sendInterval', 'sendMethod', 'respFmt', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['spnumberKey1', 'cmdKey1', 'spnumberKey2', 'cmdKey2', 'succKey', 'succValue', 'orderIdKey'], 'string', 'max' => 128],
            [['url'], 'string', 'max' => 512],
            [['rcid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'csyid' => 'Csyid',
            'rcid' => 'Rcid',
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
        ];
    }
}
