<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkProvinceTimeLimit".
 *
 * @property integer $sptid
 * @property integer $sdid
 * @property integer $prid
 * @property integer $provider
 * @property integer $stime
 * @property integer $etime
 * @property integer $updateTime
 * @property integer $recordTime
 * @property integer $status
 */
class SdkProvinceTimeLimit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkProvinceTimeLimit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sdid', 'prid', 'provider', 'stime', 'etime', 'updateTime', 'recordTime', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sptid' => 'Sptid',
            'sdid' => 'Sdid',
            'prid' => 'Prid',
            'provider' => 'Provider',
            'stime' => 'Stime',
            'etime' => 'Etime',
            'updateTime' => 'Update Time',
            'recordTime' => 'Record Time',
            'status' => 'Status',
        ];
    }
}