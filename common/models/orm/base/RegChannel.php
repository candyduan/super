<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannel".
 *
 * @property integer $rcid
 * @property string $sign
 * @property integer $merchant
 * @property string $name
 * @property integer $waitTime
 * @property string $sdkVersion
 * @property integer $devType
 * @property integer $useTelecom
 * @property integer $useMobile
 * @property integer $useUnicom
 * @property integer $cutRate
 * @property integer $inRate
 * @property integer $priorityRate
 * @property integer $holder
 * @property string $remark
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant', 'waitTime', 'devType', 'useTelecom', 'useMobile', 'useUnicom', 'cutRate', 'inRate', 'priorityRate', 'holder', 'status'], 'integer'],
            [['sdkVersion'], 'required'],
            [['recordTime', 'updateTime'], 'safe'],
            [['sign'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 128],
            [['sdkVersion'], 'string', 'max' => 45],
            [['remark'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rcid' => 'Rcid',
            'sign' => 'Sign',
            'merchant' => 'Merchant',
            'name' => 'Name',
            'waitTime' => 'Wait Time',
            'sdkVersion' => 'Sdk Version',
            'devType' => 'Dev Type',
            'useTelecom' => 'Use Telecom',
            'useMobile' => 'Use Mobile',
            'useUnicom' => 'Use Unicom',
            'cutRate' => 'Cut Rate',
            'inRate' => 'In Rate',
            'priorityRate' => 'Priority Rate',
            'holder' => 'Holder',
            'remark' => 'Remark',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
