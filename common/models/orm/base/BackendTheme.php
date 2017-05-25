<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "backendTheme".
 *
 * @property integer $btid
 * @property string $fcolor
 * @property string $bcolor
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class BackendTheme extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'backendTheme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fcolor', 'bcolor'], 'required'],
            [['recordTime', 'updateTime'], 'safe'],
            [['status'], 'integer'],
            [['fcolor', 'bcolor'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'btid' => 'Btid',
            'fcolor' => 'Fcolor',
            'bcolor' => 'Bcolor',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
