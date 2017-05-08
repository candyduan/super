<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "campaignPackageSdk".
 *
 * @property integer $cpsid
 * @property integer $cpid
 * @property integer $sdid
 * @property string $distSign
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class CampaignPackageSdk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaignPackageSdk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpid', 'sdid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['distSign'], 'string', 'max' => 45],
            [['distSign', 'sdid', 'cpid'], 'unique', 'targetAttribute' => ['distSign', 'sdid', 'cpid'], 'message' => 'The combination of Cpid, Sdid and Dist Sign has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpsid' => 'Cpsid',
            'cpid' => 'Cpid',
            'sdid' => 'Sdid',
            'distSign' => 'Dist Sign',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
