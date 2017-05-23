<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkPackagePayDay".
 *
 * @property integer $sppdid
 * @property string $date
 * @property integer $cpid
 * @property integer $sdid
 * @property integer $provider
 * @property integer $prid
 * @property integer $newUsers
 * @property integer $actUsers
 * @property integer $users
 * @property double $allPay
 * @property double $successPay
 * @property double $ratio
 * @property integer $cp
 * @property double $parpu
 * @property double $income
 * @property double $payCp
 * @property double $payM
 * @property double $profit
 * @property double $profitRatio
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkPackagePayDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkPackagePayDay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'recordTime', 'updateTime'], 'safe'],
            [['cpid', 'sdid', 'provider', 'prid', 'newUsers', 'actUsers', 'users', 'cp', 'status'], 'integer'],
            [['allPay', 'successPay', 'ratio', 'parpu', 'income', 'payCp', 'payM', 'profit', 'profitRatio'], 'number'],
            [['cpid', 'sdid', 'provider', 'prid', 'date'], 'unique', 'targetAttribute' => ['cpid', 'sdid', 'provider', 'prid', 'date'], 'message' => 'The combination of Date, Cpid, Sdid, Provider and Prid has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sppdid' => 'Sppdid',
            'date' => 'Date',
            'cpid' => 'Cpid',
            'sdid' => 'Sdid',
            'provider' => 'Provider',
            'prid' => 'Prid',
            'newUsers' => 'New Users',
            'actUsers' => 'Act Users',
            'users' => 'Users',
            'allPay' => 'All Pay',
            'successPay' => 'Success Pay',
            'ratio' => 'Ratio',
            'cp' => 'Cp',
            'parpu' => 'Parpu',
            'income' => 'Income',
            'payCp' => 'Pay Cp',
            'payM' => 'Pay M',
            'profit' => 'Profit',
            'profitRatio' => 'Profit Ratio',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
