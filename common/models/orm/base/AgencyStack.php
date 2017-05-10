<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "agencyStack".
 *
 * @property integer $asid
 * @property integer $aaid
 * @property string $imsi
 * @property string $verifyCode
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class AgencyStack extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agencyStack';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aaid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['imsi'], 'string', 'max' => 128],
            [['verifyCode'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'asid' => 'Asid',
            'aaid' => 'Aaid',
            'imsi' => 'Imsi',
            'verifyCode' => 'Verify Code',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
