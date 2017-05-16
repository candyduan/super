<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "adminAuthor".
 *
 * @property integer $aaid
 * @property integer $auid
 * @property string $power
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class AdminAuthor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adminAuthor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auid'], 'required'],
            [['auid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['power'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aaid' => 'Aaid',
            'auid' => 'Auid',
            'power' => 'Power',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
