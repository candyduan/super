<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgSd".
 *
 * @property integer $csdid
 * @property integer $channelId
 * @property integer $api
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgSd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgSd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'api', 'status'], 'integer'],
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
            'csdid' => 'Csdid',
            'channelId' => 'Channel ID',
            'api' => 'Api',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
