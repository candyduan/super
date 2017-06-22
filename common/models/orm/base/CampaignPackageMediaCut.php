<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "campaignPackageMediaCut".
 *
 * @property integer $cpmcid
 * @property integer $cpid
 * @property double $rate
 * @property string $sdate
 * @property string $edate
 * @property string $campaignPackageMediaCutcol
 * @property string $updateTime
 * @property integer $status
 */
class CampaignPackageMediaCut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaignPackageMediaCut';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpid', 'status'], 'integer'],
            [['rate'], 'number'],
            [['sdate', 'edate', 'campaignPackageMediaCutcol', 'updateTime'], 'safe'],
            [['cpid', 'sdate', 'edate'], 'unique', 'targetAttribute' => ['cpid', 'sdate', 'edate'], 'message' => 'The combination of Cpid, Sdate and Edate has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpmcid' => 'Cpmcid',
            'cpid' => 'Cpid',
            'rate' => 'Rate',
            'sdate' => 'Sdate',
            'edate' => 'Edate',
            'campaignPackageMediaCutcol' => 'Campaign Package Media Cutcol',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
