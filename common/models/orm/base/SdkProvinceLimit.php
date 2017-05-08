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
 * @property string $recordTime
 * @property string $updateTime
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
            [['sdid', 'prid', 'provider', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
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
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
