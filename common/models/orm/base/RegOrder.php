<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regOrder".
 *
 * @property integer $roid
 * @property integer $imsi
 * @property integer $rcid
 * @property string $spSign
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regOrder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roid', 'imsi', 'rcid'], 'required'],
            [['roid', 'imsi', 'rcid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['spSign'], 'string', 'max' => 128],
            [['imsi', 'rcid'], 'unique', 'targetAttribute' => ['imsi', 'rcid'], 'message' => 'The combination of Imsi and Rcid has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roid' => 'Roid',
            'imsi' => 'Imsi',
            'rcid' => 'Rcid',
            'spSign' => 'Sp Sign',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
