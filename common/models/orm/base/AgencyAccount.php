<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "agencyAccount".
 *
 * @property integer $aaid
 * @property string $name
 * @property string $account
 * @property string $passwd
 * @property string $verifyPort
 * @property string $blockPort
 * @property string $verifyKeywords
 * @property string $smtKeywords
 * @property string $blockKeywords
 * @property string $recordTime
 * @property string $updateTime
 * @property integer $status
 */
class AgencyAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agencyAccount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['passwd', 'smtKeywords'], 'required'],
            [['recordTime', 'updateTime'], 'safe'],
            [['status'], 'integer'],
            [['name', 'account', 'passwd'], 'string', 'max' => 64],
            [['verifyPort', 'blockPort'], 'string', 'max' => 32],
            [['verifyKeywords', 'smtKeywords', 'blockKeywords'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aaid' => 'Aaid',
            'name' => 'Name',
            'account' => 'Account',
            'passwd' => 'Passwd',
            'verifyPort' => 'Verify Port',
            'blockPort' => 'Block Port',
            'verifyKeywords' => 'Verify Keywords',
            'smtKeywords' => 'Smt Keywords',
            'blockKeywords' => 'Block Keywords',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'status' => 'Status',
        ];
    }
}