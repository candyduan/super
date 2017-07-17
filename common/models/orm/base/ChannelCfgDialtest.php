<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgDialtest".
 *
 * @property integer $id
 * @property integer $channelId
 * @property string $dialurl
 * @property integer $dialYes
 * @property string $dialParam
 * @property string $dialSign
 * @property string $dialSuccKey
 * @property string $dialSuccVal 
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgDialtest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgDialtest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['channelId', 'dialYes', 'status'], 'integer'],
        	[['recordTime', 'updateTime'], 'safe'],
            [['dialurl', 'dialParam'], 'string', 'max' => 255],
        	[['dialSign', 'dialSuccKey', 'dialSuccVal'], 'string', 'max' => 45],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channelId' => 'Channel ID',
            'dialurl' => 'Dialurl',
            'dialYes' => 'Dial Yes',
            'dialParam' => 'Dial Param',
        	'dialSign' => 'Dial Sign',
        	'dialSuccKey' => 'Dial Succ Key',
        	'dialSuccVal' => 'Dial Succ Val',
        	'recordTime' => 'Record Time',
        	'updateTime' => 'Update Time',
        	'status' => 'Status',
        ];
    }
}
