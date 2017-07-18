<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelMonitorRule".
 *
 * @property integer $id
 * @property integer $channel
 * @property double $totalMoney
 * @property double $totalRate
 * @property double $provinceMoney
 * @property double $provinceRate
 * @property integer $status
 * @property integer $lastTime
 * @property integer $recordTime
 * @property integer $updateTime
 */
class ChannelMonitorRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelMonitorRule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel', 'status', 'lastTime', 'recordTime', 'updateTime'], 'integer'],
            [['totalMoney', 'totalRate', 'provinceMoney', 'provinceRate'], 'number'],
            [['channel'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Channel',
            'totalMoney' => 'Total Money',
            'totalRate' => 'Total Rate',
            'provinceMoney' => 'Province Money',
            'provinceRate' => 'Province Rate',
            'status' => 'Status',
            'lastTime' => 'Last Time',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
        ];
    }
}
