<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "playerCount".
 *
 * @property integer $campaign
 * @property integer $day
 * @property string $mediaSign
 * @property integer $sdkVersion
 * @property integer $province
 * @property integer $newCount
 * @property integer $activeCount
 * @property integer $payCount
 * @property integer $partner
 * @property integer $app
 * @property integer $recordTime
 * @property integer $updateTime
 */
class PlayerCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'playerCount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign', 'day', 'mediaSign', 'sdkVersion', 'province'], 'required'],
            [['campaign', 'day', 'sdkVersion', 'province', 'newCount', 'activeCount', 'payCount', 'partner', 'app', 'recordTime', 'updateTime'], 'integer'],
            [['mediaSign'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campaign' => 'Campaign',
            'day' => 'Day',
            'mediaSign' => 'Media Sign',
            'sdkVersion' => 'Sdk Version',
            'province' => 'Province',
            'newCount' => 'New Count',
            'activeCount' => 'Active Count',
            'payCount' => 'Pay Count',
            'partner' => 'Partner',
            'app' => 'App',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
        ];
    }
}
