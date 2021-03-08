<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "client_permission".
 *
 * @property string $auto_id
 * @property string $client_id
 * @property string $app_id
 * @property string $timestamp
 */
class ClientPermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
            public $apps_name;

    public static function tableName()
    {
        return 'client_permission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'app_id'], 'required'],
            [['client_id', 'app_id'], 'integer'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'client_id' => 'Client ID',
            'app_id' => 'App ID',
            'timestamp' => 'Timestamp',
        ];
    }
     public function afterFind() {
    if(isset($this->lead)){
        $this->apps_name = $this->lead->apps_name; 
}else{

     $this->apps_name="-";
}
        /*$this->video_name =stripslashes($this->video_name);*/ 
        parent::afterFind();
    }

    public function getLead()
    {
        //TansiLeadManagement
        return $this->hasOne(AppsManagement::className(), ['auto_id' =>'client_id']);
    }
    
}

