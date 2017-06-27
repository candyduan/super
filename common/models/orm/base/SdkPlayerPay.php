<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkPlayerPay".
 *
 * @property integer $sppid
 * @property string $date
 * @property integer $scid
 * @property integer $cpid
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkPlayerPay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkPlayerPay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scid', 'cpid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['date'], 'string', 'max' => 45],
            [['scid', 'cpid', 'date'], 'unique', 'targetAttribute' => ['scid', 'cpid', 'date'], 'message' => 'The combination of Date, Scid and Cpid has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sppid' => 'Sppid',
            'date' => 'Date',
            'scid' => 'Scid',
            'cpid' => 'Cpid',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
