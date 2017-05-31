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
 * @property string $succValue
 * @property string $succKey
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
            [['cssid', 'channelId'], 'required'],
            [['cssid', 'channelId', 'sendMethod', 'respFmt', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['url'], 'string', 'max' => 512],
            [['succValue', 'succKey'], 'string', 'max' => 128],
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
            'succValue' => 'Succ Value',
            'succKey' => 'Succ Key',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
