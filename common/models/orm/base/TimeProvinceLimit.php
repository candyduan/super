<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "timeProvinceLimit".
 *
 * @property integer $id
 * @property integer $channel
 * @property integer $province
 * @property integer $h0
 * @property integer $h1
 * @property integer $h2
 * @property integer $h3
 * @property integer $h4
 * @property integer $h5
 * @property integer $h6
 * @property integer $h7
 * @property integer $h8
 * @property integer $h9
 * @property integer $h10
 * @property integer $h11
 * @property integer $h12
 * @property integer $h13
 * @property integer $h14
 * @property integer $h15
 * @property integer $h16
 * @property integer $h17
 * @property integer $h18
 * @property integer $h19
 * @property integer $h20
 * @property integer $h21
 * @property integer $h22
 * @property integer $h23
 */
class TimeProvinceLimit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'timeProvinceLimit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel', 'province', 'h0', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7', 'h8', 'h9', 'h10', 'h11', 'h12', 'h13', 'h14', 'h15', 'h16', 'h17', 'h18', 'h19', 'h20', 'h21', 'h22', 'h23'], 'integer'],
            [['channel', 'province'], 'unique', 'targetAttribute' => ['channel', 'province'], 'message' => 'The combination of Channel and Province has already been taken.'],
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
            'province' => 'Province',
            'h0' => 'H0',
            'h1' => 'H1',
            'h2' => 'H2',
            'h3' => 'H3',
            'h4' => 'H4',
            'h5' => 'H5',
            'h6' => 'H6',
            'h7' => 'H7',
            'h8' => 'H8',
            'h9' => 'H9',
            'h10' => 'H10',
            'h11' => 'H11',
            'h12' => 'H12',
            'h13' => 'H13',
            'h14' => 'H14',
            'h15' => 'H15',
            'h16' => 'H16',
            'h17' => 'H17',
            'h18' => 'H18',
            'h19' => 'H19',
            'h20' => 'H20',
            'h21' => 'H21',
            'h22' => 'H22',
            'h23' => 'H23',
        ];
    }
}
