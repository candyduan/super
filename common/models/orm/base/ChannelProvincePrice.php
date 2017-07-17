<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelProvincePrice".
 *
 * @property integer $id
 * @property integer $channel
 * @property integer $province
 * @property integer $price
 * @property integer $status
 * @property integer $recordTime
 * @property integer $updateTime
 */
class ChannelProvincePrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelProvincePrice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel', 'province', 'price', 'status', 'recordTime', 'updateTime'], 'integer'],
            [['channel', 'province', 'price'], 'unique', 'targetAttribute' => ['channel', 'province', 'price'], 'message' => 'The combination of Channel, Province and Price has already been taken.'],
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
            'province' => 'Province',
            'price' => 'Price',
            'status' => 'Status',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
        ];
    }
}
