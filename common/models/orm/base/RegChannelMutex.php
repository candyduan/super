<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelMutex".
 *
 * @property integer $rcmid
 * @property string $name
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelMutex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelMutex';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recordTime', 'updateTime'], 'safe'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rcmid' => 'Rcmid',
            'name' => 'Name',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
