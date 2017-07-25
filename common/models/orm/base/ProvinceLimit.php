<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "provinceLimit".
 *
 * @property integer $id
 * @property integer $channel
 * @property integer $province
 * @property integer $dayLimit
 * @property integer $monthLimit
 * @property integer $playerDayLimit
 * @property integer $playerMonthLimit
 * @property integer $opened
 * @property integer $weight
 * @property integer $yesterdayRate
 * @property integer $lastHourRate
 * @property integer $lastThreeHoursRate
 * @property integer $lastSixHoursRate
 * @property integer $dayRequestLimit
 * @property integer $monthRequestLimit
 * @property integer $playerDayRequestLimit
 * @property integer $playerMonthRequestLimit
 * @property integer $unfreezeTime
 */
class ProvinceLimit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provinceLimit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel', 'province', 'dayLimit', 'monthLimit', 'playerDayLimit', 'playerMonthLimit', 'opened', 'weight', 'yesterdayRate', 'lastHourRate', 'lastThreeHoursRate', 'lastSixHoursRate', 'dayRequestLimit', 'monthRequestLimit', 'playerDayRequestLimit', 'playerMonthRequestLimit', 'unfreezeTime'], 'integer'],
            [['playerMonthLimit'], 'required'],
            [['channel', 'province'], 'unique', 'targetAttribute' => ['channel', 'province'], 'message' => 'The combination of Channel and Province has already been taken.'],
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
            'dayLimit' => 'Day Limit',
            'monthLimit' => 'Month Limit',
            'playerDayLimit' => 'Player Day Limit',
            'playerMonthLimit' => 'Player Month Limit',
            'opened' => 'Opened',
            'weight' => 'Weight',
            'yesterdayRate' => 'Yesterday Rate',
            'lastHourRate' => 'Last Hour Rate',
            'lastThreeHoursRate' => 'Last Three Hours Rate',
            'lastSixHoursRate' => 'Last Six Hours Rate',
            'dayRequestLimit' => 'Day Request Limit',
            'monthRequestLimit' => 'Month Request Limit',
            'playerDayRequestLimit' => 'Player Day Request Limit',
            'playerMonthRequestLimit' => 'Player Month Request Limit',
            'unfreezeTime' => 'Unfreeze Time',
        ];
    }
}
