<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "merchant".
 *
 * @property integer $id
 * @property string $name
 * @property string $addr
 * @property integer $holder
 * @property integer $payCircle
 * @property integer $payType
 * @property double $tax
 * @property integer $payer
 * @property string $memo
 * @property integer $deleted
 * @property integer $updateTime
 * @property integer $recordTime
 */
class Merchant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['holder', 'payCircle', 'payType', 'payer', 'deleted', 'updateTime', 'recordTime'], 'integer'],
            [['tax'], 'number'],
            [['name'], 'string', 'max' => 150],
            [['addr'], 'string', 'max' => 250],
            [['memo'], 'string', 'max' => 500],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'addr' => 'Addr',
            'holder' => 'Holder',
            'payCircle' => 'Pay Circle',
            'payType' => 'Pay Type',
            'tax' => 'Tax',
            'payer' => 'Payer',
            'memo' => 'Memo',
            'deleted' => 'Deleted',
            'updateTime' => 'Update Time',
            'recordTime' => 'Record Time',
        ];
    }
}
