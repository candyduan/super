<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgSms".
 *
 * @property integer $ccsid
 * @property integer $rcid
 * @property integer $api
 * @property integer $smtType
 * @property string $smtKeywords
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelCfgSms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelCfgSms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcid'], 'required'],
            [['rcid', 'api', 'smtType', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['smtKeywords'], 'string', 'max' => 128],
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
            'api' => 'Api',
            'smtType' => 'Smt Type',
            'smtKeywords' => 'Smt Keywords',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
