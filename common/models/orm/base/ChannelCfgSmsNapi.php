<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgSmsNapi".
 *
 * @property integer $csnid
 * @property integer $channelId
 * @property integer $needExt
 * @property string $sms1
 * @property string $sms2
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgSmsNapi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgSmsNapi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'needExt', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['sms1', 'sms2'], 'string', 'max' => 2048],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'csnid' => 'Csnid',
            'channelId' => 'Channel ID',
            'needExt' => 'Need Ext',
            'sms1' => 'Sms1',
            'sms2' => 'Sms2',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}