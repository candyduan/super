<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "partner".
 *
 * @property integer $id
 * @property string $pwd
 * @property string $email
 * @property string $name
 * @property integer $bank
 * @property string $subBank
 * @property string $accountName
 * @property string $account
 * @property integer $holder
 * @property double $afPercent
 * @property integer $payCircle
 * @property integer $payType
 * @property integer $needInvoice
 * @property double $tax
 * @property integer $payer
 * @property string $memo
 * @property integer $deleted
 * @property string $sign
 * @property integer $utype
 * @property integer $agent
 * @property integer $needSync
 * @property string $syncUrl
 * @property integer $updateTime
 * @property integer $recordTime
 * @property integer $belong
 */
class Partner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank', 'holder', 'payCircle', 'payType', 'needInvoice', 'payer', 'deleted', 'utype', 'agent', 'needSync', 'updateTime', 'recordTime', 'belong'], 'integer'],
            [['afPercent', 'tax'], 'number'],
            [['memo'], 'required'],
            [['memo'], 'string'],
            [['pwd'], 'string', 'max' => 64],
            [['email', 'subBank', 'accountName'], 'string', 'max' => 150],
            [['name'], 'string', 'max' => 128],
            [['account', 'sign'], 'string', 'max' => 45],
            [['syncUrl'], 'string', 'max' => 250],
            [['email'], 'unique'],
            [['sign'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pwd' => 'Pwd',
            'email' => 'Email',
            'name' => 'Name',
            'bank' => 'Bank',
            'subBank' => 'Sub Bank',
            'accountName' => 'Account Name',
            'account' => 'Account',
            'holder' => 'Holder',
            'afPercent' => 'Af Percent',
            'payCircle' => 'Pay Circle',
            'payType' => 'Pay Type',
            'needInvoice' => 'Need Invoice',
            'tax' => 'Tax',
            'payer' => 'Payer',
            'memo' => 'Memo',
            'deleted' => 'Deleted',
            'sign' => 'Sign',
            'utype' => 'Utype',
            'agent' => 'Agent',
            'needSync' => 'Need Sync',
            'syncUrl' => 'Sync Url',
            'updateTime' => 'Update Time',
            'recordTime' => 'Record Time',
            'belong' => 'Belong',
        ];
    }
}
