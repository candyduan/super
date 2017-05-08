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
 * @property string $recordTime
 * @property string $updateTime
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
            [['sdid', 'stime', 'etime', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
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
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
