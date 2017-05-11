<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regProfit".
 *
 * @property integer $rpid
 * @property integer $rcid
 * @property string $day
 * @property integer $succ
 * @property integer $fail
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegProfit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regProfit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcid'], 'required'],
            [['rcid', 'succ', 'fail', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['day'], 'string', 'max' => 45],
            [['day', 'rcid'], 'unique', 'targetAttribute' => ['day', 'rcid'], 'message' => 'The combination of Rcid and Day has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rpid' => 'Rpid',
            'rcid' => 'Rcid',
            'day' => 'Day',
            'succ' => 'Succ',
            'fail' => 'Fail',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
