<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "outUser".
 *
 * @property integer $ouid
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property integer $partner
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class OutUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'outUser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner', 'status'], 'integer'],
            [['recordTime', 'updateTime'], 'safe'],
            [['username', 'password_hash', 'email'], 'string', 'max' => 45],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ouid' => 'Ouid',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'partner' => 'Partner',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
