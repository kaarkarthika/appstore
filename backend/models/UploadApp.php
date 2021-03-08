<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "upload_app".
 *
 * @property integer $auto_id
 * @property string $upload_apk
 * @property string $app_description
 */
class UploadApp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $file;
    public $appsname;
    public static function tableName()
    {
        return 'upload_app';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           /* [['auto_id'], 'required'],*/
            [['auto_id','upload_id'], 'integer'],
            [['upload_apk', 'app_description'], 'string', 'max' => 255],
            [['create_date', 'update_date','app_version'], 'safe'],
            [['upload_apk'], 'file', 'extensions'=>'apk'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Apps',
            'upload_apk' => 'Upload Apk',
            'app_description' => 'App Description',
             'app_version' =>'App Version',
             'create_date' => 'create_date',
             'update_date' => 'update_date',          
        ];
    }

public function afterFind() {
    if(isset($this->lead)){
        $this->appsname = $this->lead->apps_name; 
}else{

     $this->appsname="-";
}
        /*$this->video_name =stripslashes($this->video_name);*/ 
        parent::afterFind();
    }

    public function getLead()
    {
        //TansiLeadManagement
        return $this->hasOne(AppsManagement::className(), ['auto_id' =>'upload_id']);
    }
    
}

