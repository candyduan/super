<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgToSync".
 *
 * @property integer $ctsid
 * @property integer $channelId
 * @property string $port
 * @property string $command
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgToSync extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgToSync';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['port', 'command'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ctsid' => 'Ctsid',
            'channelId' => 'Channel ID',
            'port' => 'Port',
            'command' => 'Command',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}