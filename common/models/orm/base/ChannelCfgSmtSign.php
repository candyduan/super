<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgSmtSign".
 *
 * @property integer $cssid
 * @property integer $channelId
 * @property integer $method
 * @property string $parameters
 * @property integer $resHandle
 * @property string $connector
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgSmtSign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgSmtSign';
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
            [['connector'], 'string', 'max' => 128],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cssid' => 'Cssid',
            'channelId' => 'Channel ID',
            'method' => 'Method',
            'parameters' => 'Parameters',
            'resHandle' => 'Res Handle',
            'connector' => 'Connector',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}