<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgSdNapi".
 *
 * @property integer $sdnid
 * @property integer $channelId
 * @property string $sms1
 * @property string $sms2
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgSdNapi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgSdNapi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'status'], 'integer'],
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
            'sdnid' => 'Sdnid',
            'channelId' => 'Channel ID',
            'sms1' => 'Sms1',
            'sms2' => 'Sms2',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
