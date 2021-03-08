<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "apps_management".
 *
 * @property integer $auto_id
 * @property string $apps_logo
 * @property string $apps_name
 * @property string $apps_description
 */
class AppsManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public static function tableName()
    {
        return 'apps_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           /* [['auto_id'], 'required'],
            [['auto_id'], 'integer'],*/
            [['apps_logo', 'apps_name', 'apps_description','company_name'], 'string', 'max' => 255],
            [['create_date', 'update_date'], 'safe'],
           [['apps_logo','company_logo'], 'file', 'extensions'=>'jpg, gif, png'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'apps_logo' => 'Apps Logo',
            'apps_name' => 'Apps Name',
            'apps_description' => 'Apps Description',
            'company_name' => 'Company Name',
            'company_logo' => 'Company Logo',
            'create_date' => 'create_date',
            'update_date' => 'update_date',
        ];
    }
}
