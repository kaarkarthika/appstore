<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\Session;
use yii\web\IdentityInterface;

use backend\models\DropdownManagement;
use common\models\ClientManagement;
use backend\models\TansiServiceCentre;

/**
 * This is the model class for table "tansi_service_centre_admin".
 *
 * @property string $id
 * @property string $servicecenter_id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $dob
 * @property string $user_type
 * @property string $city
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property string $created_at
 * @property string $timestamp
 * @property string $rights
 * @property string $status_flag
 * @property string $user_level
 * @property string $mobile_number
 * @property string $designation
 */
class ClientManagement extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
   
    public static function tableName()
    {
        return 'client_management';
    }

    public function rules()
    {
        return [
            //['status', 'default', 'value' => self::STATUS_ACTIVE],
           // ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

     public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['tansi_service_centre_admin.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
/**
     * @inheritdoc
     */
    public function getId()
    {   return 1;
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
   /* public function rules()
    {
        return [
            [['servicecenter_id', 'username','password_hash'], 'required'],

            [['username'], 'unique'],
            [['dob', 'created_at', 'timestamp'], 'safe'],
            [['user_type', 'rights', 'status_flag'], 'string'],
            [['status'], 'integer'],
            [['servicecenter_id', 'user_level', 'mobile_number'], 'string', 'max' => 20],
            [['username', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'city'], 'string', 'max' => 70],
            [['auth_key'], 'string', 'max' => 32],
            [['designation'], 'string', 'max' => 100],
        ];
    }*/

    /**
     * @inheritdoc
     */
    
    public function login()
    {
        
        $session = Yii::$app->session;
       // unset($session['user_id']);
        //unset($session['user_name']);
        $session->destroy();

         $username = $_REQUEST['LoginForm']['username'];
         $password = $_REQUEST['LoginForm']['password'];
        if ($username!='' && $password!='') {
            $user_data = ClientManagement::find()->where(['client_name' => $username])->one();
            $haspassword=$user_data->password_hash;

             if(!isset($haspassword)){
             $haspassword=Yii::$app->security->generatePasswordHash(date("Y-m-d"));
             }

            if(Yii::$app->security->validatePassword($password,$haspassword)){
                $session['user_id']  = $user_data->auto_id;
				$session['user_name']  = $user_data->client_name;
                
                $session['user_logintype']  = 'R1'; 
                 
                return Yii::$app->user->login($user_data, false ? 3600 * 24 * 30 : 0);              
            }else{
                return FALSE;
            }
            
        } else {            
            return false;
        }
    }
   

    // public function getService()
    // {
    //     return $this->hasOne(TansiServiceCentreAdmin::className(), ['center_autoid' => 'servicecenter_id']);
    // }
}
