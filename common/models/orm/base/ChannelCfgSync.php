<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgSync".
 *
 * @property integer $csid
 * @property integer $channelId
 * @property string $succKey
 * @property string $succValue
 * @property string $cpparamKey
 * @property string $feeKey
 * @property integer $feeUnit
 * @property string $cmdKey
 * @property string $succReturn
 * @property string $mobileKey
 * @property string $feeFixed
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgSync extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgSync';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'feeUnit', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['succKey', 'succValue', 'cpparamKey', 'feeKey', 'cmdKey', 'succReturn', 'mobileKey', 'feeFixed'], 'string', 'max' => 128],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'csid' => 'Csid',
            'channelId' => 'Channel ID',
            'succKey' => 'Succ Key',
            'succValue' => 'Succ Value',
            'cpparamKey' => 'Cpparam Key',
            'feeKey' => 'Fee Key',
            'feeUnit' => 'Fee Unit',
            'cmdKey' => 'Cmd Key',
            'succReturn' => 'Succ Return',
            'mobileKey' => 'Mobile Key',
            'feeFixed' => 'Fee Fixed',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}