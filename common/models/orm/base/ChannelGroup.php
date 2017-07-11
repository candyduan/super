<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "channelGroup".
 *
 * @property integer $id
 * @property string $name
 * @property integer $uniqueLimit
 * @property integer $cdTime
 * @property integer $dayLimit
 * @property integer $dayRequestLimit
 * @property integer $monthLimit
 * @property integer $monthRequestLimit
 * @property integer $recordTime
 * @property integer $updateTime
 */
class ChannelGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channelGroup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uniqueLimit', 'cdTime', 'dayLimit', 'dayRequestLimit', 'monthLimit', 'monthRequestLimit', 'recordTime', 'updateTime'], 'integer'],
            [['name'], 'string', 'max' => 120],
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
            'uniqueLimit' => 'Unique Limit',
            'cdTime' => 'Cd Time',
            'dayLimit' => 'Day Limit',
            'dayRequestLimit' => 'Day Request Limit',
            'monthLimit' => 'Month Limit',
            'monthRequestLimit' => 'Month Request Limit',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
        ];
    }
}
