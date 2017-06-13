<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgOut".
 *
 * @property integer $coid
 * @property integer $channelId
 * @property string $spSignPrefix
 * @property string $url
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgOut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgOut';
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
            [['spSignPrefix'], 'string', 'max' => 32],
            [['url'], 'string', 'max' => 512],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'coid' => 'Coid',
            'channelId' => 'Channel ID',
            'spSignPrefix' => 'Sp Sign Prefix',
            'url' => 'Url',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
