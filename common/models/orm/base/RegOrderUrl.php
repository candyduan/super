<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "regOrderUrl".
 *
 * @property integer $ouid
 * @property integer $rcid
 * @property string $url
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class RegOrderUrl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regOrderUrl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rcid'], 'required'],
            [['rcid', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['url'], 'string', 'max' => 512],
            [['rcid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ouid' => 'Ouid',
            'rcid' => 'Rcid',
            'url' => 'Url',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
