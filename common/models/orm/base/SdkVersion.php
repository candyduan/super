<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "sdkVersion".
 *
 * @property integer $id
 * @property integer $versionCode
 * @property string $versionName
 * @property string $path
 * @property string $desc
 * @property integer $status
 * @property string $plugins
 * @property integer $recordTime
 * @property integer $updateTime
 */
class SdkVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sdkVersion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['versionCode', 'status', 'recordTime', 'updateTime'], 'integer'],
            [['desc'], 'required'],
            [['desc'], 'string'],
            [['versionName'], 'string', 'max' => 20],
            [['path'], 'string', 'max' => 45],
            [['plugins'], 'string', 'max' => 120],
            [['versionCode'], 'unique'],
            [['versionName'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'versionCode' => 'Version Code',
            'versionName' => 'Version Name',
            'path' => 'Path',
            'desc' => 'Desc',
            'status' => 'Status',
            'plugins' => 'Plugins',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
        ];
    }
}
