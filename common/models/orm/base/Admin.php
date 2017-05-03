<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $name
 * @property string $nick
 * @property string $email
 * @property string $pwd
 * @property integer $type
 * @property integer $recordTime
 * @property integer $updateTime
 * @property integer $lastLoginTime
 * @property string $lastLoginIP
 * @property string $memo
 * @property integer $deleted
 * @property string $sign
 * @property integer $signTime
 * @property string $header
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'recordTime', 'updateTime', 'lastLoginTime', 'deleted', 'signTime'], 'integer'],
            [['name', 'nick', 'lastLoginIP'], 'string', 'max' => 45],
            [['email', 'memo'], 'string', 'max' => 100],
            [['pwd', 'sign'], 'string', 'max' => 64],
            [['header'], 'string', 'max' => 128],
            [['name'], 'unique'],
            [['nick'], 'unique'],
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
            'nick' => 'Nick',
            'email' => 'Email',
            'pwd' => 'Pwd',
            'type' => 'Type',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'lastLoginTime' => 'Last Login Time',
            'lastLoginIP' => 'Last Login Ip',
            'memo' => 'Memo',
            'deleted' => 'Deleted',
            'sign' => 'Sign',
            'signTime' => 'Sign Time',
            'header' => 'Header',
        ];
    }
}
