<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkSort".
 *
 * @property integer $ssid
 * @property integer $provider
 * @property string $sort
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkSort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkSort';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['sort'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ssid' => 'Ssid',
            'provider' => 'Provider',
            'sort' => 'Sort',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
