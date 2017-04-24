<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgSmsSubmit".
 *
 * @property integer $cssid
 * @property integer $rcid
 * @property string $url
 * @property integer $sendMethod
 * @property integer $respFmt
 * @property string $succValue
 * @property string $succKey
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelCfgSmsSubmit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelCfgSmsSubmit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cssid', 'rcid'], 'required'],
            [['cssid', 'rcid', 'sendMethod', 'respFmt', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['url'], 'string', 'max' => 512],
            [['succValue', 'succKey'], 'string', 'max' => 128],
            [['rcid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cssid' => 'Cssid',
            'rcid' => 'Rcid',
            'url' => 'Url',
            'sendMethod' => 'Send Method',
            'respFmt' => 'Resp Fmt',
            'succValue' => 'Succ Value',
            'succKey' => 'Succ Key',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
