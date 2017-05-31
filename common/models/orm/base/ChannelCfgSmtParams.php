<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgSmtParams".
 *
 * @property integer $cspid
 * @property integer $channelId
 * @property string $orderIdKey
 * @property string $verifyCodeKey
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class ChannelCfgSmtParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgSmtParams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['orderIdKey', 'verifyCodeKey'], 'string', 'max' => 128],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cspid' => 'Cspid',
            'channelId' => 'Channel ID',
            'orderIdKey' => 'Order Id Key',
            'verifyCodeKey' => 'Verify Code Key',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
