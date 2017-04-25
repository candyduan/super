<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelVerifyRule".
 *
 * @property integer $cvrid
 * @property integer $rcid
 * @property string $port
 * @property string $keys1
 * @property string $keys2
 * @property string $keys3
 * @property integer $type
 * @property string $memo
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelVerifyRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelVerifyRule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcid'], 'required'],
            [['rcid', 'type', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['port'], 'string', 'max' => 64],
            [['keys1', 'keys2', 'keys3'], 'string', 'max' => 128],
            [['memo'], 'string', 'max' => 512],
            [['rcid', 'type'], 'unique', 'targetAttribute' => ['rcid', 'type'], 'message' => 'The combination of Rcid and Type has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cvrid' => 'Cvrid',
            'rcid' => 'Rcid',
            'port' => 'Port',
            'keys1' => 'Keys1',
            'keys2' => 'Keys2',
            'keys3' => 'Keys3',
            'type' => 'Type',
            'memo' => 'Memo',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
