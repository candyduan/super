<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkPlayer".
 *
 * @property integer $spid
 * @property string $imsi
 * @property string $imei
 * @property integer $cpid
 * @property string $date
 * @property integer $isNew
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkPlayer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkPlayer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpid', 'isNew', 'status'], 'integer'],
            [['date', 'recordTime', 'updateTime'], 'safe'],
            [['imsi', 'imei'], 'string', 'max' => 128],
            [['imsi', 'cpid', 'date'], 'unique', 'targetAttribute' => ['imsi', 'cpid', 'date'], 'message' => 'The combination of Imsi, Cpid and Date has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'spid' => 'Spid',
            'imsi' => 'Imsi',
            'imei' => 'Imei',
            'cpid' => 'Cpid',
            'date' => 'Date',
            'isNew' => 'Is New',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
