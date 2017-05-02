<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkPayDay".
 *
 * @property integer $spdid
 * @property integer $sdid
 * @property integer $provider
 * @property integer $prid
 * @property integer $allPay
 * @property integer $successPay
 * @property double $ratio
 * @property string $date
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkPayDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkPayDay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sdid', 'provider', 'prid', 'allPay', 'successPay', 'status'], 'integer'],
            [['ratio'], 'number'],
            [['date', 'recordTime', 'updateTime'], 'safe'],
            [['date', 'sdid', 'provider', 'prid'], 'unique', 'targetAttribute' => ['date', 'sdid', 'provider', 'prid'], 'message' => 'The combination of Sdid, Provider, Prid and Date has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'spdid' => 'Spdid',
            'sdid' => 'Sdid',
            'provider' => 'Provider',
            'prid' => 'Prid',
            'allPay' => 'All Pay',
            'successPay' => 'Success Pay',
            'ratio' => 'Ratio',
            'date' => 'Date',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
