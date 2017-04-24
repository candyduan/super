<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgUrl".
 *
 * @property integer $ccuid
 * @property integer $rcid
 * @property string $regSpnumber
 * @property string $regKeywords
 * @property string $trgUrl
 * @property integer $trgSendMethod
 * @property integer $trgRespFmt
 * @property string $trgSuccKey
 * @property string $trgSuccValue
 * @property string $trgOrderIdKey
 * @property string $trgSmtKey
 * @property integer $smtType
 * @property string $smtKeywords
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelCfgUrl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelCfgUrl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcid'], 'required'],
            [['rcid', 'trgSendMethod', 'trgRespFmt', 'smtType', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['regSpnumber', 'regKeywords', 'trgSuccKey', 'trgSuccValue', 'trgOrderIdKey', 'trgSmtKey', 'smtKeywords'], 'string', 'max' => 128],
            [['trgUrl'], 'string', 'max' => 512],
            [['rcid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ccuid' => 'Ccuid',
            'rcid' => 'Rcid',
            'regSpnumber' => 'Reg Spnumber',
            'regKeywords' => 'Reg Keywords',
            'trgUrl' => 'Trg Url',
            'trgSendMethod' => 'Trg Send Method',
            'trgRespFmt' => 'Trg Resp Fmt',
            'trgSuccKey' => 'Trg Succ Key',
            'trgSuccValue' => 'Trg Succ Value',
            'trgOrderIdKey' => 'Trg Order Id Key',
            'trgSmtKey' => 'Trg Smt Key',
            'smtType' => 'Smt Type',
            'smtKeywords' => 'Smt Keywords',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
