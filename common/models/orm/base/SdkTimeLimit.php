<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkTimeLimit".
 *
 * @property integer $stid
 * @property integer $sdid
 * @property integer $stime
 * @property integer $etime
 * @property integer $updateTime
 * @property integer $recordTime
 * @property integer $status
 */
class SdkTimeLimit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkTimeLimit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sdid', 'stime', 'etime', 'updateTime', 'recordTime', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stid' => 'Stid',
            'sdid' => 'Sdid',
            'stime' => 'Stime',
            'etime' => 'Etime',
            'updateTime' => 'Update Time',
            'recordTime' => 'Record Time',
            'status' => 'Status',
        ];
    }
}
