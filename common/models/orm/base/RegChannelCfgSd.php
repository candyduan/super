<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgSd".
 *
 * @property integer $csdid
 * @property integer $rcid
 * @property integer $api
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelCfgSd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelCfgSd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcid'], 'required'],
            [['rcid', 'api', 'status'], 'integer'],
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
            'csdid' => 'Csdid',
            'rcid' => 'Rcid',
            'api' => 'Api',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
