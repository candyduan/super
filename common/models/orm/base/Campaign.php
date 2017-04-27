<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "campaign".
 *
 * @property integer $id
 * @property string $name
 * @property integer $partner
 * @property integer $app
 * @property integer $beginDate
 * @property integer $endDate
 * @property integer $status
 * @property integer $inPrice
 * @property integer $outPrice
 * @property double $rate
 * @property double $mrate
 * @property integer $type
 * @property string $sign
 * @property string $memo
 * @property string $desc
 * @property integer $deleted
 * @property integer $holder
 * @property integer $isTest
 * @property integer $recordTime
 * @property integer $updateTime
 * @property double $cutRate
 * @property string $syncAddr
 * @property string $material
 * @property string $materialName
 * @property integer $cutDay
 * @property integer $agent
 * @property double $agentCutRate
 * @property integer $agentCutDay
 * @property double $agentRate
 * @property integer $grade
 * @property integer $belong
 * @property integer $payMode
 */
class Campaign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner', 'app', 'beginDate', 'endDate', 'status', 'inPrice', 'outPrice', 'type', 'deleted', 'holder', 'isTest', 'recordTime', 'updateTime', 'cutDay', 'agent', 'agentCutDay', 'grade', 'belong', 'payMode'], 'integer'],
            [['rate', 'mrate', 'cutRate', 'agentCutRate', 'agentRate'], 'number'],
            [['memo', 'desc'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['sign'], 'string', 'max' => 128],
            [['syncAddr'], 'string', 'max' => 250],
            [['material'], 'string', 'max' => 64],
            [['materialName'], 'string', 'max' => 200],
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
            'partner' => 'Partner',
            'app' => 'App',
            'beginDate' => 'Begin Date',
            'endDate' => 'End Date',
            'status' => 'Status',
            'inPrice' => 'In Price',
            'outPrice' => 'Out Price',
            'rate' => 'Rate',
            'mrate' => 'Mrate',
            'type' => 'Type',
            'sign' => 'Sign',
            'memo' => 'Memo',
            'desc' => 'Desc',
            'deleted' => 'Deleted',
            'holder' => 'Holder',
            'isTest' => 'Is Test',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'cutRate' => 'Cut Rate',
            'syncAddr' => 'Sync Addr',
            'material' => 'Material',
            'materialName' => 'Material Name',
            'cutDay' => 'Cut Day',
            'agent' => 'Agent',
            'agentCutRate' => 'Agent Cut Rate',
            'agentCutDay' => 'Agent Cut Day',
            'agentRate' => 'Agent Rate',
            'grade' => 'Grade',
            'belong' => 'Belong',
            'payMode' => 'Pay Mode',
        ];
    }
}
