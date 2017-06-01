<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgSms".
 *
 * @property integer $csid
 * @property integer $channelId
 * @property integer $api
 * @property integer $smtType
 * @property string $smtKeywords
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgSms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgSms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'api', 'smtType', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['smtKeywords'], 'string', 'max' => 128],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'csid' => 'Csid',
            'channelId' => 'Channel ID',
            'api' => 'Api',
            'smtType' => 'Smt Type',
            'smtKeywords' => 'Smt Keywords',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
