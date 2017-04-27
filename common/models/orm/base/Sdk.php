<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdk".
 *
 * @property integer $sdid
 * @property integer $spid
 * @property string $name
 * @property integer $updateTime
 * @property integer $recordTime
 * @property integer $status
 * @property integer $proportion
 * @property integer $optimization
 * @property string $syn
 * @property string $remark
 * @property integer $limit
 * @property string $sign
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
            [['spid', 'updateTime', 'recordTime', 'status', 'proportion', 'optimization', 'limit'], 'integer'],
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
            'updateTime' => 'Update Time',
            'recordTime' => 'Record Time',
            'status' => 'Status',
            'proportion' => 'Proportion',
            'optimization' => 'Optimization',
            'syn' => 'Syn',
            'remark' => 'Remark',
            'limit' => 'Limit',
            'sign' => 'Sign',
        ];
    }
}
