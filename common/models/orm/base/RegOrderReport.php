<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regOrderReport".
 *
 * @property integer $rorid
 * @property integer $roid
 * @property string $content1
 * @property string $content2
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegOrderReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regOrderReport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roid'], 'required'],
            [['roid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['content1', 'content2'], 'string', 'max' => 10240],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rorid' => 'Rorid',
            'roid' => 'Roid',
            'content1' => 'Content1',
            'content2' => 'Content2',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
