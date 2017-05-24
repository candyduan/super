<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkPayTransaction".
 *
 * @property integer $sptid
 * @property integer $sdid
 * @property integer $provider
 * @property integer $prid
 * @property string $cpOrder
 * @property string $sdkOrder
 * @property integer $price
 * @property integer $cpid
 * @property integer $scid
 * @property integer $clientStatus
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkPayTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkPayTransaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sdid', 'provider', 'prid', 'price', 'cpid', 'scid', 'clientStatus', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['cpOrder', 'sdkOrder'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sptid' => 'Sptid',
            'sdid' => 'Sdid',
            'provider' => 'Provider',
            'prid' => 'Prid',
            'cpOrder' => 'Cp Order',
            'sdkOrder' => 'Sdk Order',
            'price' => 'Price',
            'cpid' => 'Cpid',
            'scid' => 'Scid',
            'clientStatus' => 'Client Status',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
