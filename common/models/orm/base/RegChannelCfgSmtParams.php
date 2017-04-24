<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regChannelCfgSmtParams".
 *
 * @property integer $cspid
 * @property integer $rcid
 * @property string $orderIdKey
 * @property string $verifyCodeKey
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegChannelCfgSmtParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regChannelCfgSmtParams';
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
            [['orderIdKey', 'verifyCodeKey'], 'string', 'max' => 128],
            [['rcid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cspid' => 'Cspid',
            'rcid' => 'Rcid',
            'orderIdKey' => 'Order Id Key',
            'verifyCodeKey' => 'Verify Code Key',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
