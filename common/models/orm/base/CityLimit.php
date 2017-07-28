<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "cityLimit".
 *
 * @property integer $id
 * @property integer $channel
 * @property integer $city
 * @property integer $province
 * @property integer $deleted
 */
class CityLimit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cityLimit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel', 'city', 'province', 'deleted'], 'integer'],
            [['channel', 'city'], 'unique', 'targetAttribute' => ['channel', 'city'], 'message' => 'The combination of Channel and City has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Channel',
            'city' => 'City',
            'province' => 'Province',
            'deleted' => 'Deleted',
        ];
    }
}
