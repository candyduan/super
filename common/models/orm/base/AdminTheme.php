<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "adminTheme".
 *
 * @property integer $atid
 * @property integer $auid
 * @property integer $btid
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class AdminTheme extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adminTheme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auid', 'btid'], 'required'],
            [['auid', 'btid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['auid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'atid' => 'Atid',
            'auid' => 'Auid',
            'btid' => 'Btid',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
