<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkPartner".
 *
 * @property integer $spid
 * @property string $name
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class SdkPartner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkPartner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recordTime', 'updateTime'], 'safe'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'spid' => 'Spid',
            'name' => 'Name',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
