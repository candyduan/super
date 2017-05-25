<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "campaignPackage".
 *
 * @property integer $id
 * @property integer $campaign
 * @property string $mediaSign
 * @property integer $media
 * @property integer $partner
 * @property integer $app
 * @property double $rate
 * @property double $mrate
 * @property integer $mtype
 * @property double $cutRate
 * @property integer $cutDay
 * @property string $apk
 * @property string $cdnSign
 * @property string $cdnUrl
 * @property integer $size
 * @property integer $opened
 * @property integer $versionCode
 * @property string $versionName
 * @property integer $agent
 * @property double $agentCutRate
 * @property integer $agentCutDay
 * @property double $agentRate
 * @property integer $grade
 * @property integer $recordTime
 * @property integer $updateTime
 * @property integer $quickFB
 * @property integer $needConfirm
 * @property integer $mobileImportant
 * @property integer $showRes
 * @property integer $showLoading
 * @property integer $preMobile
 * @property integer $adStatus
 * @property integer $payMode
 * @property integer $mcutDay
 * @property double $mcutRate
 */
class CampaignPackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaignPackage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign', 'media', 'partner', 'app', 'mtype', 'cutDay', 'size', 'opened', 'versionCode', 'agent', 'agentCutDay', 'grade', 'recordTime', 'updateTime', 'quickFB', 'needConfirm', 'mobileImportant', 'showRes', 'showLoading', 'preMobile', 'adStatus', 'payMode', 'mcutDay'], 'integer'],
            [['rate', 'mrate', 'cutRate', 'agentCutRate', 'agentRate', 'mcutRate'], 'number'],
            [['mediaSign'], 'string', 'max' => 64],
            [['apk'], 'string', 'max' => 128],
            [['cdnSign', 'versionName'], 'string', 'max' => 45],
            [['cdnUrl'], 'string', 'max' => 150],
            [['campaign', 'mediaSign'], 'unique', 'targetAttribute' => ['campaign', 'mediaSign'], 'message' => 'The combination of Campaign and Media Sign has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campaign' => 'Campaign',
            'mediaSign' => 'Media Sign',
            'media' => 'Media',
            'partner' => 'Partner',
            'app' => 'App',
            'rate' => 'Rate',
            'mrate' => 'Mrate',
            'mtype' => 'Mtype',
            'cutRate' => 'Cut Rate',
            'cutDay' => 'Cut Day',
            'apk' => 'Apk',
            'cdnSign' => 'Cdn Sign',
            'cdnUrl' => 'Cdn Url',
            'size' => 'Size',
            'opened' => 'Opened',
            'versionCode' => 'Version Code',
            'versionName' => 'Version Name',
            'agent' => 'Agent',
            'agentCutRate' => 'Agent Cut Rate',
            'agentCutDay' => 'Agent Cut Day',
            'agentRate' => 'Agent Rate',
            'grade' => 'Grade',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'quickFB' => 'Quick Fb',
            'needConfirm' => 'Need Confirm',
            'mobileImportant' => 'Mobile Important',
            'showRes' => 'Show Res',
            'showLoading' => 'Show Loading',
            'preMobile' => 'Pre Mobile',
            'adStatus' => 'Ad Status',
            'payMode' => 'Pay Mode',
            'mcutDay' => 'Mcut Day',
            'mcutRate' => 'Mcut Rate',
        ];
    }
}
