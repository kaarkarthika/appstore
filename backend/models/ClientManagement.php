<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "client_management".
 *
 * @property integer $auto_id
 * @property string $client_name
 * @property string $email_id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 */
class ClientManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
        public $apps_name;
    public static function tableName()
    {
        return 'client_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['auto_id'], 'required'],
            [['auto_id'], 'integer'],
            [['client_name', 'email_id','apps_name'], 'required'],
            [['client_name', 'email_id', 'password_hash', 'password_reset_token','notification_id'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['client_name'], 'unique'],
            [['password_reset_token'], 'unique'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'client_name' => 'Client Name',
            'email_id' => 'Email ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'notification_id' => 'Notification_Id'        ];
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

