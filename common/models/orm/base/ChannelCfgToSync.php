<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgToSync".
 *
 * @property integer $id
 * @property integer $channel
 * @property string $syncPort
 * @property string $syncCommand
 * @property integer $status
 * @property integer $recordTime
 * @property integer $updateTime
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
            [['id'], 'required'],
            [['id', 'channel', 'status', 'recordTime', 'updateTime'], 'integer'],
            [['syncPort', 'syncCommand'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Channel',
            'syncPort' => 'Sync Port',
            'syncCommand' => 'Sync Command',
            'status' => 'Status',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
        ];
    }
}