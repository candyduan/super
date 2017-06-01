<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgUrl".
 *
 * @property integer $cuid
 * @property integer $channelId
 * @property integer $smtType
 * @property string $smtKeywords
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgUrl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgUrl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'smtType', 'status'], 'integer'],
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
            'cuid' => 'Cuid',
            'channelId' => 'Channel ID',
            'smtType' => 'Smt Type',
            'smtKeywords' => 'Smt Keywords',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
