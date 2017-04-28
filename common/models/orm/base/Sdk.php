<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdk".
 *
 * @property integer $sdid
 * @property integer $spid
 * @property string $name
 * @property integer $proportion
 * @property integer $optimization
 * @property string $syn
 * @property string $remark
 * @property integer $limit
 * @property string $sign
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class Sdk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spid', 'proportion', 'optimization', 'limit', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['name', 'remark'], 'string', 'max' => 45],
            [['syn'], 'string', 'max' => 200],
            [['sign'], 'string', 'max' => 10],
            [['sign'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sdid' => 'Sdid',
            'spid' => 'Spid',
            'name' => 'Name',
            'proportion' => 'Proportion',
            'optimization' => 'Optimization',
            'syn' => 'Syn',
            'remark' => 'Remark',
            'limit' => 'Limit',
            'sign' => 'Sign',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
