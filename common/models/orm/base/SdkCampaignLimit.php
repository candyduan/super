<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkCampaignLimit".
 *
 * @property integer $sclid
 * @property integer $sdid
 * @property integer $caid
 * @property integer $type
 * @property integer $updateTime
 * @property integer $recordTime
 * @property integer $status
 */
class SdkCampaignLimit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkCampaignLimit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sdid', 'caid', 'type', 'updateTime', 'recordTime', 'status'], 'integer'],
            [['sdid', 'caid', 'type'], 'unique', 'targetAttribute' => ['sdid', 'caid', 'type'], 'message' => 'The combination of Sdid, Caid and Type has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sclid' => 'Sclid',
            'sdid' => 'Sdid',
            'caid' => 'Caid',
            'type' => 'Type',
            'updateTime' => 'Update Time',
            'recordTime' => 'Record Time',
            'status' => 'Status',
        ];
    }
}
