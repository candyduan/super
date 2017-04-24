<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgMain".
 *
 * @property integer $ccmid
 * @property integer $rcid
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelCfgMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelCfgMain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ccmid', 'rcid'], 'required'],
            [['ccmid', 'rcid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['rcid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ccmid' => 'Ccmid',
            'rcid' => 'Rcid',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
