<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelSwitch".
 *
 * @property integer $rcsid
 * @property integer $rcid
 * @property integer $hour00
 * @property integer $hour01
 * @property integer $hour02
 * @property integer $hour03
 * @property integer $hour04
 * @property integer $hour05
 * @property integer $hour06
 * @property integer $hour07
 * @property integer $hour08
 * @property integer $hour09
 * @property integer $hour10
 * @property integer $hour11
 * @property integer $hour12
 * @property integer $hour13
 * @property integer $hour14
 * @property integer $hour15
 * @property integer $hour16
 * @property integer $hour17
 * @property integer $hour18
 * @property integer $hour19
 * @property integer $hour20
 * @property integer $hour21
 * @property integer $hour22
 * @property integer $hour23
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelSwitch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelSwitch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcid'], 'required'],
            [['rcid', 'hour00', 'hour01', 'hour02', 'hour03', 'hour04', 'hour05', 'hour06', 'hour07', 'hour08', 'hour09', 'hour10', 'hour11', 'hour12', 'hour13', 'hour14', 'hour15', 'hour16', 'hour17', 'hour18', 'hour19', 'hour20', 'hour21', 'hour22', 'hour23', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['rcid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rcsid' => 'Rcsid',
            'rcid' => 'Rcid',
            'hour00' => 'Hour00',
            'hour01' => 'Hour01',
            'hour02' => 'Hour02',
            'hour03' => 'Hour03',
            'hour04' => 'Hour04',
            'hour05' => 'Hour05',
            'hour06' => 'Hour06',
            'hour07' => 'Hour07',
            'hour08' => 'Hour08',
            'hour09' => 'Hour09',
            'hour10' => 'Hour10',
            'hour11' => 'Hour11',
            'hour12' => 'Hour12',
            'hour13' => 'Hour13',
            'hour14' => 'Hour14',
            'hour15' => 'Hour15',
            'hour16' => 'Hour16',
            'hour17' => 'Hour17',
            'hour18' => 'Hour18',
            'hour19' => 'Hour19',
            'hour20' => 'Hour20',
            'hour21' => 'Hour21',
            'hour22' => 'Hour22',
            'hour23' => 'Hour23',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
