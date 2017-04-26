<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkProvinceLimit".
 *
 * @property integer $splid
 * @property integer $sdid
 * @property integer $prid
 * @property integer $provider
 * @property integer $updateTime
 * @property integer $recordTime
 * @property integer $status
 */
class SdkProvinceLimit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkProvinceLimit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sdid', 'prid', 'provider', 'updateTime', 'recordTime', 'status'], 'integer'],
            [['sdid', 'prid', 'provider'], 'unique', 'targetAttribute' => ['sdid', 'prid', 'provider'], 'message' => 'The combination of Sdid, Prid and Provider has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'splid' => 'Splid',
            'sdid' => 'Sdid',
            'prid' => 'Prid',
            'provider' => 'Provider',
            'updateTime' => 'Update Time',
            'recordTime' => 'Record Time',
            'status' => 'Status',
        ];
    }
}
