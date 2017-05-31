<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "developerChannelCount".
 *
 * @property integer $id
 * @property string $name
 * @property integer $count
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class DeveloperChannelCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'developerChannelCount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'count', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['id'], 'unique'],
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
            'count' => 'Count',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
