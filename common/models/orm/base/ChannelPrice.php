<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelPrice".
 *
 * @property integer $id
 * @property integer $channel
 * @property integer $price
 * @property string $code
 * @property integer $status
 * @property integer $recordTime
 * @property integer $updateTime
 */
class ChannelPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelPrice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel', 'price', 'status', 'recordTime', 'updateTime'], 'integer'],
            [['code'], 'string', 'max' => 128],
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
            'price' => 'Price',
            'code' => 'Code',
            'status' => 'Status',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
        ];
    }
}
