<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channel".
 *
 * @property integer $id
 * @property string $name
 * @property integer $merchant
 * @property integer $provider
 * @property string $sign
 * @property integer $dayLimit
 * @property integer $monthLimit
 * @property integer $playerDayLimit
 * @property integer $playerMonthLimit
 * @property integer $priority
 * @property integer $rcCount
 * @property integer $cmpCount
 * @property integer $quality
 * @property integer $realQuality
 * @property integer $status
 * @property string $memo
 * @property integer $needMobile
 * @property integer $priceOpen
 * @property integer $limitCampaign
 * @property string $syncSign
 * @property integer $recordTime
 * @property integer $updateTime
 * @property integer $yesterdayTime
 * @property integer $todayTime
 * @property integer $cdTime
 * @property double $inPrice
 * @property integer $devType
 * @property integer $onDuty
 * @property integer $holder
 * @property double $cutRate
 * @property integer $minSDKVersion
 * @property integer $payLimitType
 * @property integer $solidPriority
 * @property integer $groupID
 * @property integer $groupUnique
 * @property integer $groupLimit
 * @property integer $grade
 * @property integer $dayRequestLimit
 * @property integer $monthRequestLimit
 * @property integer $playerDayRequestLimit
 * @property integer $playerMonthRequestLimit
 * @property integer $unfreezeTime
 * @property string $syncOutput
 * @property integer $isReplyMessage
 */
class Channel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant', 'provider', 'dayLimit', 'monthLimit', 'playerDayLimit', 'playerMonthLimit', 'priority', 'rcCount', 'cmpCount', 'quality', 'realQuality', 'status', 'needMobile', 'priceOpen', 'limitCampaign', 'recordTime', 'updateTime', 'yesterdayTime', 'todayTime', 'cdTime', 'devType', 'onDuty', 'holder', 'minSDKVersion', 'payLimitType', 'solidPriority', 'groupID', 'groupUnique', 'groupLimit', 'grade', 'dayRequestLimit', 'monthRequestLimit', 'playerDayRequestLimit', 'playerMonthRequestLimit', 'unfreezeTime', 'isReplyMessage'], 'integer'],
            [['inPrice', 'cutRate'], 'number'],
            [['name'], 'string', 'max' => 150],
            [['sign'], 'string', 'max' => 128],
            [['memo'], 'string', 'max' => 500],
            [['syncSign'], 'string', 'max' => 10],
            [['syncOutput'], 'string', 'max' => 45],
            [['sign'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'merchant' => 'Merchant',
            'provider' => 'Provider',
            'sign' => 'Sign',
            'dayLimit' => 'Day Limit',
            'monthLimit' => 'Month Limit',
            'playerDayLimit' => 'Player Day Limit',
            'playerMonthLimit' => 'Player Month Limit',
            'priority' => 'Priority',
            'rcCount' => 'Rc Count',
            'cmpCount' => 'Cmp Count',
            'quality' => 'Quality',
            'realQuality' => 'Real Quality',
            'status' => 'Status',
            'memo' => 'Memo',
            'needMobile' => 'Need Mobile',
            'priceOpen' => 'Price Open',
            'limitCampaign' => 'Limit Campaign',
            'syncSign' => 'Sync Sign',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'yesterdayTime' => 'Yesterday Time',
            'todayTime' => 'Today Time',
            'cdTime' => 'Cd Time',
            'inPrice' => 'In Price',
            'devType' => 'Dev Type',
            'onDuty' => 'On Duty',
            'holder' => 'Holder',
            'cutRate' => 'Cut Rate',
            'minSDKVersion' => 'Min Sdkversion',
            'payLimitType' => 'Pay Limit Type',
            'solidPriority' => 'Solid Priority',
            'groupID' => 'Group ID',
            'groupUnique' => 'Group Unique',
            'groupLimit' => 'Group Limit',
            'grade' => 'Grade',
            'dayRequestLimit' => 'Day Request Limit',
            'monthRequestLimit' => 'Month Request Limit',
            'playerDayRequestLimit' => 'Player Day Request Limit',
            'playerMonthRequestLimit' => 'Player Month Request Limit',
            'unfreezeTime' => 'Unfreeze Time',
            'syncOutput' => 'Sync Output',
            'isReplyMessage' => 'Is Reply Message',
        ];
    }
}
