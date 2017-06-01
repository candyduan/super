<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgMain".
 *
 * @property integer $cmid
 * @property integer $channelId
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgMain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cmid' => 'Cmid',
            'channelId' => 'Channel ID',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
