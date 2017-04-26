<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkProvinceTimeLimit".
 *
 * @property integer $sptid
 * @property integer $splid
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
            [['sptid'], 'required'],
            [['sptid', 'splid', 'stime', 'etime', 'updateTime', 'recordTime', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sptid' => 'Sptid',
            'splid' => 'Splid',
            'stime' => 'Stime',
            'etime' => 'Etime',
            'updateTime' => 'Update Time',
            'recordTime' => 'Record Time',
            'status' => 'Status',
        ];
    }
}
