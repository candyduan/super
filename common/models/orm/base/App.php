<?php

namespace common\models\orm\base;

use Yii;

/**
 * This is the model class for table "app".
 *
 * @property integer $id
 * @property integer $partner
 * @property string $name
 * @property integer $category
 * @property string $desc
 * @property string $packageName
 * @property string $publishID
 * @property integer $versionCode
 * @property string $versionName
 * @property integer $star
 * @property string $apk
 * @property string $material
 * @property string $icon
 * @property string $snap1
 * @property string $snap2
 * @property string $snap3
 * @property string $snap4
 * @property string $snap5
 * @property integer $verifiedTime
 * @property string $size
 * @property string $publicKeySignature
 * @property string $signature
 * @property integer $deleted
 * @property integer $agent
 * @property integer $grade
 * @property integer $recordTime
 * @property integer $updateTime
 * @property integer $releaseTime
 */
class App extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner', 'category', 'versionCode', 'star', 'verifiedTime', 'size', 'deleted', 'agent', 'grade', 'recordTime', 'updateTime', 'releaseTime'], 'integer'],
            [['apk'], 'required'],
            [['name', 'packageName'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 500],
            [['publishID'], 'string', 'max' => 64],
            [['versionName', 'material', 'icon', 'snap1', 'snap2', 'snap3', 'snap4', 'snap5', 'publicKeySignature', 'signature'], 'string', 'max' => 45],
            [['apk'], 'string', 'max' => 128],
            [['packageName'], 'unique'],
            [['publishID'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner' => 'Partner',
            'name' => 'Name',
            'category' => 'Category',
            'desc' => 'Desc',
            'packageName' => 'Package Name',
            'publishID' => 'Publish ID',
            'versionCode' => 'Version Code',
            'versionName' => 'Version Name',
            'star' => 'Star',
            'apk' => 'Apk',
            'material' => 'Material',
            'icon' => 'Icon',
            'snap1' => 'Snap1',
            'snap2' => 'Snap2',
            'snap3' => 'Snap3',
            'snap4' => 'Snap4',
            'snap5' => 'Snap5',
            'verifiedTime' => 'Verified Time',
            'size' => 'Size',
            'publicKeySignature' => 'Public Key Signature',
            'signature' => 'Signature',
            'deleted' => 'Deleted',
            'agent' => 'Agent',
            'grade' => 'Grade',
            'recordTime' => 'Record Time',
            'updateTime' => 'Update Time',
            'releaseTime' => 'Release Time',
        ];
    }
}
