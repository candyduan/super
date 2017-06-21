<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgPaySign".
 *
 * @property integer $cpsid
 * @property integer $channelId
 * @property integer $method
 * @property string $parameters
 * @property integer $resHandle
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgPaySign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgPaySign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId', 'method'], 'required'],
            [['channelId', 'method', 'resHandle', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['parameters'], 'string', 'max' => 1024],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpsid' => 'Cpsid',
            'channelId' => 'Channel ID',
            'method' => 'Method',
            'parameters' => 'Parameters',
            'resHandle' => 'Res Handle',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
