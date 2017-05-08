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
 * @property string $recordTime
 * @property string $updateTime
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
            [['sdid', 'prid', 'provider', 'stime', 'etime', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
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
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
