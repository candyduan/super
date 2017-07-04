<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgUrlSdkSubmit".
 *
 * @property integer $ussid
 * @property integer $channelId
 * @property string $portFixed
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgUrlSdkSubmit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgUrlSdkSubmit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['portFixed'], 'string', 'max' => 128],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ussid' => 'Ussid',
            'channelId' => 'Channel ID',
            'portFixed' => 'Port Fixed',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
