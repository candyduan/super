<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelMutexList".
 *
 * @property integer $rcmlid
 * @property integer $rcmid
 * @property integer $rcid
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelMutexList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelMutexList';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcmid', 'rcid'], 'required'],
            [['rcmid', 'rcid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['rcmid', 'rcid'], 'unique', 'targetAttribute' => ['rcmid', 'rcid'], 'message' => 'The combination of Rcmid and Rcid has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rcmlid' => 'Rcmlid',
            'rcmid' => 'Rcmid',
            'rcid' => 'Rcid',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
