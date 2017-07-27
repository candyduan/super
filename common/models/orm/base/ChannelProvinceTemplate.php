<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelProvinceTemplate".
 *
 * @property integer $cptid
 * @property integer $channelId
 * @property integer $dayLimit
 * @property integer $monthLimit
 * @property integer $playerDayLimit
 * @property integer $playerMonthLimit
 * @property integer $dayRequestLimit
 * @property integer $monthRequestLimit
 * @property integer $playerDayRequestLimit
 * @property integer $playerMonthRequestLimit
 * @property string $unFreezeTime
 * @property integer $opened
 * @property string $price
 * @property string $time
 * @property string $recordTime
 * @property string $updateTime
 */
class ChannelProvinceTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelProvinceTemplate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'dayLimit', 'monthLimit', 'playerDayLimit', 'playerMonthLimit', 'dayRequestLimit', 'monthRequestLimit', 'playerDayRequestLimit', 'playerMonthRequestLimit', 'opened'], 'integer'],
            [['unFreezeTime', 'recordTime', 'updateTime'], 'safe'],
            [['price', 'time'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cptid' => 'Cptid',
            'channelId' => 'Channel ID',
            'dayLimit' => 'Day Limit',
            'monthLimit' => 'Month Limit',
            'playerDayLimit' => 'Player Day Limit',
            'playerMonthLimit' => 'Player Month Limit',
            'dayRequestLimit' => 'Day Request Limit',
            'monthRequestLimit' => 'Month Request Limit',
            'playerDayRequestLimit' => 'Player Day Request Limit',
            'playerMonthRequestLimit' => 'Player Month Request Limit',
            'unFreezeTime' => 'Un Freeze Time',
            'opened' => 'Opened',
            'price' => 'Price',
            'time' => 'Time',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
        ];
    }
}
