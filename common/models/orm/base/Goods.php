<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $type
 * @property string $sign
 * @property integer $partner
 * @property integer $app
 * @property integer $campaign
 * @property string $fee
 * @property integer $onSale
 * @property integer $deleted
 * @property integer $recordTime
 * @property integer $updateTime
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'partner', 'app', 'campaign', 'fee', 'onSale', 'deleted', 'recordTime', 'updateTime'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['desc'], 'string', 'max' => 500],
            [['sign'], 'string', 'max' => 128],
            [['sign'], 'unique'],
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
            'desc' => 'Desc',
            'type' => 'Type',
            'sign' => 'Sign',
            'partner' => 'Partner',
            'app' => 'App',
            'campaign' => 'Campaign',
            'fee' => 'Fee',
            'onSale' => 'On Sale',
            'deleted' => 'Deleted',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
        ];
    }
}
