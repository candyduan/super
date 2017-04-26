<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgUrl".
 *
 * @property integer $ccuid
 * @property integer $rcid
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
            [['rcid', 'smtType', 'status'], 'integer'],
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
            'ccuid' => 'Ccuid',
            'rcid' => 'Rcid',
            'smtType' => 'Smt Type',
            'smtKeywords' => 'Smt Keywords',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
