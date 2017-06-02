<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgSmsSubmit".
 *
 * @property integer $cssid
 * @property integer $channelId
 * @property string $url
 * @property integer $sendMethod
 * @property integer $respFmt
 * @property string $succKey
 * @property string $succValue
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgSmsSubmit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgSmsSubmit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'sendMethod', 'respFmt', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['url'], 'string', 'max' => 512],
            [['succKey', 'succValue'], 'string', 'max' => 128],
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
            'url' => 'Url',
            'sendMethod' => 'Send Method',
            'respFmt' => 'Resp Fmt',
            'succKey' => 'Succ Key',
            'succValue' => 'Succ Value',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}