<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelCfgUrlYapi".
 *
 * @property integer $cuyid
 * @property integer $channelId
 * @property string $url
 * @property integer $sendMethod
 * @property integer $respFmt
 * @property string $succValue
 * @property string $succKey
 * @property string $orderIdKey
 * @property string $smtKey
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 * @property string $delimiter
 */
class ChannelCfgUrlYapi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelCfgUrlYapi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channelId'], 'required'],
            [['channelId', 'sendMethod', 'respFmt', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['url'], 'string', 'max' => 512],
            [['succValue', 'succKey', 'orderIdKey', 'smtKey'], 'string', 'max' => 128],
            [['delimiter'], 'string', 'max' => 45],
            [['channelId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cuyid' => 'Cuyid',
            'channelId' => 'Channel ID',
            'url' => 'Url',
            'sendMethod' => 'Send Method',
            'respFmt' => 'Resp Fmt',
            'succValue' => 'Succ Value',
            'succKey' => 'Succ Key',
            'orderIdKey' => 'Order Id Key',
            'smtKey' => 'Smt Key',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
            'delimiter' => 'Delimiter',
        ];
    }
}