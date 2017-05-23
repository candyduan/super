<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "payAction".
 *
 * @property integer $id
 * @property integer $campaignPackage
 * @property integer $channel
 * @property integer $media
 * @property integer $day
 * @property integer $agent
 * @property double $totalMoney
 * @property double $successMoney
 * @property integer $isAgent
 * @property double $agentMoney
 * @property double $agentRate
 * @property double $partnerMoney
 * @property double $partnerRate
 * @property integer $mediaType
 * @property double $mediaRate
 * @property integer $mediaCount
 * @property double $merchantRate
 * @property integer $agentHolder
 * @property integer $agentStatus
 * @property integer $agentBillNO
 * @property integer $partner
 * @property integer $app
 * @property integer $campaign
 * @property integer $partnerHolder
 * @property integer $partnerStatus
 * @property integer $partnerBillNO
 * @property string $mediaSign
 * @property integer $mediaHolder
 * @property integer $mediaStatus
 * @property integer $mediaBillNO
 * @property integer $merchant
 * @property integer $merchantHolder
 * @property integer $merchantStatus
 * @property integer $merchantBillNO
 * @property integer $newPlayerCount
 * @property integer $activePlayerCount
 * @property integer $payPlayerCount
 * @property integer $newPlayerCountAgent
 * @property integer $activePlayerCountAgent
 * @property integer $payPlayerCountAgent
 * @property integer $newPlayerCountPartner
 * @property integer $activePlayerCountPartner
 * @property integer $payPlayerCountPartner
 * @property integer $recordTime
 * @property integer $updateTime
 * @property integer $fixed
 */
class PayAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payAction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaignPackage', 'channel', 'media', 'day', 'agent', 'isAgent', 'mediaType', 'mediaCount', 'agentHolder', 'agentStatus', 'agentBillNO', 'partner', 'app', 'campaign', 'partnerHolder', 'partnerStatus', 'partnerBillNO', 'mediaHolder', 'mediaStatus', 'mediaBillNO', 'merchant', 'merchantHolder', 'merchantStatus', 'merchantBillNO', 'newPlayerCount', 'activePlayerCount', 'payPlayerCount', 'newPlayerCountAgent', 'activePlayerCountAgent', 'payPlayerCountAgent', 'newPlayerCountPartner', 'activePlayerCountPartner', 'payPlayerCountPartner', 'recordTime', 'updateTime', 'fixed'], 'integer'],
            [['totalMoney', 'successMoney', 'agentMoney', 'agentRate', 'partnerMoney', 'partnerRate', 'mediaRate', 'merchantRate'], 'number'],
            [['mediaSign'], 'string', 'max' => 64],
            [['campaignPackage', 'channel', 'media', 'day', 'agent'], 'unique', 'targetAttribute' => ['campaignPackage', 'channel', 'media', 'day', 'agent'], 'message' => 'The combination of Campaign Package, Channel, Media, Day and Agent has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campaignPackage' => 'Campaign Package',
            'channel' => 'Channel',
            'media' => 'Media',
            'day' => 'Day',
            'agent' => 'Agent',
            'totalMoney' => 'Total Money',
            'successMoney' => 'Success Money',
            'isAgent' => 'Is Agent',
            'agentMoney' => 'Agent Money',
            'agentRate' => 'Agent Rate',
            'partnerMoney' => 'Partner Money',
            'partnerRate' => 'Partner Rate',
            'mediaType' => 'Media Type',
            'mediaRate' => 'Media Rate',
            'mediaCount' => 'Media Count',
            'merchantRate' => 'Merchant Rate',
            'agentHolder' => 'Agent Holder',
            'agentStatus' => 'Agent Status',
            'agentBillNO' => 'Agent Bill No',
            'partner' => 'Partner',
            'app' => 'App',
            'campaign' => 'Campaign',
            'partnerHolder' => 'Partner Holder',
            'partnerStatus' => 'Partner Status',
            'partnerBillNO' => 'Partner Bill No',
            'mediaSign' => 'Media Sign',
            'mediaHolder' => 'Media Holder',
            'mediaStatus' => 'Media Status',
            'mediaBillNO' => 'Media Bill No',
            'merchant' => 'Merchant',
            'merchantHolder' => 'Merchant Holder',
            'merchantStatus' => 'Merchant Status',
            'merchantBillNO' => 'Merchant Bill No',
            'newPlayerCount' => 'New Player Count',
            'activePlayerCount' => 'Active Player Count',
            'payPlayerCount' => 'Pay Player Count',
            'newPlayerCountAgent' => 'New Player Count Agent',
            'activePlayerCountAgent' => 'Active Player Count Agent',
            'payPlayerCountAgent' => 'Pay Player Count Agent',
            'newPlayerCountPartner' => 'New Player Count Partner',
            'activePlayerCountPartner' => 'Active Player Count Partner',
            'payPlayerCountPartner' => 'Pay Player Count Partner',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'fixed' => 'Fixed',
        ];
    }
}
