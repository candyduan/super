<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdk".
 *
 * @property integer $sdid
 * @property integer $spid
 * @property string common$name
 * @property integer $updateTime
 * @property integer $recordTime
 * @property integer $status
 * @property integer $proportion
 * @property integer $optimization
 * @property string $syn
 * @property string $remark
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
            [['spid', 'updateTime', 'recordTime', 'status', 'proportion', 'optimization'], 'integer'],
            [['name', 'remark'], 'string', 'max' => 45],
            [['syn'], 'string', 'max' => 200],
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
        ];
    }
}
