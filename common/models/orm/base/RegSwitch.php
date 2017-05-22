<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regSwitch".
 *
 * @property integer $rsid
 * @property integer $campaignPackageId
 * @property string $stime
 * @property string $etime
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegSwitch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regSwitch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaignPackageId', 'status'], 'integer'],
            [['stime', 'etime', 'recordTime', 'updateTime'], 'safe'],
            [['campaignPackageId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rsid' => 'Rsid',
            'campaignPackageId' => 'Campaign Package ID',
            'stime' => 'Stime',
            'etime' => 'Etime',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
