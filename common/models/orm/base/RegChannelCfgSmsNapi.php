<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgSmsNapi".
 *
 * @property integer $csnid
 * @property integer $rcid
 * @property string $sms1
 * @property string $sms2
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelCfgSmsNapi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelCfgSmsNapi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcid'], 'required'],
            [['rcid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['sms1', 'sms2'], 'string', 'max' => 2048],
            [['rcid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'csnid' => 'Csnid',
            'rcid' => 'Rcid',
            'sms1' => 'Sms1',
            'sms2' => 'Sms2',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
