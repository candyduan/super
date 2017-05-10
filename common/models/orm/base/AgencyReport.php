<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "agencyReport".
 *
 * @property integer $arid
 * @property integer $aaid
 * @property string $day
 * @property integer $succ
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class AgencyReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agencyReport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aaid'], 'required'],
            [['aaid', 'succ', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['day'], 'string', 'max' => 45],
            [['aaid', 'day'], 'unique', 'targetAttribute' => ['aaid', 'day'], 'message' => 'The combination of Aaid and Day has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'arid' => 'Arid',
            'aaid' => 'Aaid',
            'day' => 'Day',
            'succ' => 'Succ',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
