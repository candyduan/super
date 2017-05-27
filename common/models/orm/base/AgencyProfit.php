<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "agencyProfit".
 *
 * @property integer $apid
 * @property integer $aaid
 * @property string $day
 * @property integer $succ
 * @property integer $fail
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class AgencyProfit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agencyProfit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aaid'], 'required'],
            [['aaid', 'succ', 'fail', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['day'], 'string', 'max' => 45],
            [['day', 'aaid'], 'unique', 'targetAttribute' => ['day', 'aaid'], 'message' => 'The combination of Aaid and Day has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'apid' => 'Apid',
            'aaid' => 'Aaid',
            'day' => 'Day',
            'succ' => 'Succ',
            'fail' => 'Fail',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
