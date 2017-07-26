<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkPlayerPayCount".
 *
 * @property integer $sppcid
 * @property string $date
 * @property integer $cpid
 * @property integer $prid
 * @property integer $provider
 * @property integer $sdid
 * @property integer $payUsers
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkPlayerPayCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkPlayerPayCount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'recordTime', 'updateTime'], 'safe'],
            [['cpid', 'prid', 'provider', 'sdid', 'payUsers', 'status'], 'integer'],
            [['date', 'cpid', 'prid', 'provider', 'sdid'], 'unique', 'targetAttribute' => ['date', 'cpid', 'prid', 'provider', 'sdid'], 'message' => 'The combination of Date, Cpid, Prid, Provider and Sdid has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sppcid' => 'Sppcid',
            'date' => 'Date',
            'cpid' => 'Cpid',
            'prid' => 'Prid',
            'provider' => 'Provider',
            'sdid' => 'Sdid',
            'payUsers' => 'Pay Users',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
