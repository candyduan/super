<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "campaignSdkGoods".
 *
 * @property integer $csgid
 * @property integer $csid
 * @property integer $goid
 * @property string $priceSign
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class CampaignSdkGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaignSdkGoods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['csid', 'goid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['priceSign'], 'string', 'max' => 45],
            [['goid', 'csid'], 'unique', 'targetAttribute' => ['goid', 'csid'], 'message' => 'The combination of Csid and Goid has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'csgid' => 'Csgid',
            'csid' => 'Csid',
            'goid' => 'Goid',
            'priceSign' => 'Price Sign',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
