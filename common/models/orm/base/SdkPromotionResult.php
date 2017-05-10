<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkPromotionResult".
 *
 * @property integer $sprid
 * @property integer $cpid
 * @property string $date
 * @property integer $count
 * @property integer $price
 * @property integer $amount
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkPromotionResult extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkPromotionResult';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpid', 'count', 'price', 'amount', 'status'], 'integer'],
            [['date', 'recordTime', 'updateTime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sprid' => 'Sprid',
            'cpid' => 'Cpid',
            'date' => 'Date',
            'count' => 'Count',
            'price' => 'Price',
            'amount' => 'Amount',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
