<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkProvinceSort".
 *
 * @property integer $spsid
 * @property integer $provider
 * @property integer $prid
 * @property string $sort
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkProvinceSort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkProvinceSort';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider', 'prid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['sort'], 'string', 'max' => 100],
            [['provider', 'prid'], 'unique', 'targetAttribute' => ['provider', 'prid'], 'message' => 'The combination of Provider and Prid has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'spsid' => 'Spsid',
            'provider' => 'Provider',
            'prid' => 'Prid',
            'sort' => 'Sort',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
