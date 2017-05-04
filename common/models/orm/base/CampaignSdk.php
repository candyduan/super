<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "campaignSdk".
 *
 * @property integer $csid
 * @property integer $caid
 * @property integer $sdid
 * @property string $appid
 * @property string $sec
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class CampaignSdk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaignSdk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['caid', 'sdid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['appid'], 'string', 'max' => 30],
            [['sec'], 'string', 'max' => 45],
            [['caid', 'sdid'], 'unique', 'targetAttribute' => ['caid', 'sdid'], 'message' => 'The combination of Caid and Sdid has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'csid' => 'Csid',
            'caid' => 'Caid',
            'sdid' => 'Sdid',
            'appid' => 'Appid',
            'sec' => 'Sec',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
