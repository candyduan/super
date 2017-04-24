<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgSync".
 *
 * @property integer $ccsid
 * @property integer $rcid
 * @property string $succKey
 * @property string $succValue
 * @property string $cpparamKey
 * @property string $succReturn
 * @property string $mobileKey
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelCfgSync extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelCfgSync';
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
            [['succKey', 'succValue', 'cpparamKey', 'succReturn', 'mobileKey'], 'string', 'max' => 128],
            [['rcid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ccsid' => 'Ccsid',
            'rcid' => 'Rcid',
            'succKey' => 'Succ Key',
            'succValue' => 'Succ Value',
            'cpparamKey' => 'Cpparam Key',
            'succReturn' => 'Succ Return',
            'mobileKey' => 'Mobile Key',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
