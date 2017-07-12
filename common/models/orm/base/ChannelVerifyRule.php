<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelVerifyRule".
 *
 * @property integer $id
 * @property integer $channel
 * @property string $port
 * @property string $keys1
 * @property string $keys2
 * @property string $keys3
 * @property integer $recordTime
 * @property integer $updateTime
 * @property string $memo
 * @property integer $type
 */
class ChannelVerifyRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelVerifyRule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel', 'recordTime', 'updateTime', 'type'], 'integer'],
            [['port'], 'string', 'max' => 45],
            [['keys1', 'keys2', 'keys3'], 'string', 'max' => 100],
            [['memo'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Channel',
            'port' => 'Port',
            'keys1' => 'Keys1',
            'keys2' => 'Keys2',
            'keys3' => 'Keys3',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'memo' => 'Memo',
            'type' => 'Type',
        ];
    }
}
