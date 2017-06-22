<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkPlayerCount".
 *
 * @property integer $spcid
 * @property string $date
 * @property integer $cpid
 * @property integer $newUsers
 * @property integer $actUsers
 * @property integer $payUsers
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkPlayerCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkPlayerCount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpid', 'newUsers', 'actUsers', 'payUsers', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['date'], 'string', 'max' => 20],
            [['date', 'cpid'], 'unique', 'targetAttribute' => ['date', 'cpid'], 'message' => 'The combination of Date and Cpid has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'spcid' => 'Spcid',
            'date' => 'Date',
            'cpid' => 'Cpid',
            'newUsers' => 'New Users',
            'actUsers' => 'Act Users',
            'payUsers' => 'Pay Users',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
