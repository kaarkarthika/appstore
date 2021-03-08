<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\InvoiceAccessoriesGrouping;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use backend\models\AppsManagement;
use backend\models\ClientManagement;
use backend\models\ClientPermission;
use backend\models\UploadApp;
use backend\models\ApiVersion;
use yii\db\Expression; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\db\Query;
use common\models\User;

class AppStoreController extends Controller
{

           public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

     public function beforeAction($action) {    
	$params = (Yii::$app->request->headers);
 
	if($authorization=$params['authorization']){		
		$this->enableCsrfValidation = false;
    	return parent::beforeAction($action);
	}else{
   $list = array();
   $list['status'] = 'error';
   $list['message'] = 'Invalid Authorization Request!';		
   $response['Output'][]=$list;
		echo json_encode($response);
	}
} 
function authorization(){  
	$params = (Yii::$app->request->headers);
	$authorization=$params['authorization'];
	$authorization=str_replace('Bearer', '', $authorization);
	$authorization=trim($authorization);
	$model = ClientManagement::find()
					->where(['auth_key'=>$authorization])
					->one();
	if($model){ 
		return $model;
	}
}
        /*APP LIST*/
public function actionAppList()
{

  $data=Url::base(true);
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($model=$this->authorization()){
    $client_id=$model->auto_id;  
    //print_r($client_id);die;
    $field_check=array('apk_key');
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
       
    }else{ 
      $apk_key = $requestInput['apk_key'];
      if($apk_key=="list_apk"){
        $ClientManagement=ClientPermission::find()
          ->where(['client_id'=>$client_id])
          ->asArray()
          ->all();
       //echo"<pre>";print_r($ClientManagement);die;
        $details=ArrayHelper::map($ClientManagement, 'app_id', 'app_id');
         $AppsManagement = AppsManagement::find()
         ->Where(['IN','auto_id',$details])
          ->asArray()
          ->all();
          //echo"<pre>";print_r($AppsManagement);die;
 
           if(!empty($AppsManagement)){
        foreach ($AppsManagement as $key => $value) {
          $AppsManagement=UploadApp::find()
            ->where(['upload_id'=>$value['auto_id']])
            ->asArray()
            ->orderBy(['update_date'=>SORT_DESC])
            ->one();
          
            //echo"<pre>";print_r(gethostname());die;

          $det['apps_logo'] = $data."/backend/web/".$value['apps_logo'];       
          $det['company_logo'] = $data."/backend/web/".$value['company_logo'];       
          $det['company_name'] = $value['company_name'];       
          $det['apps_name'] = $value['apps_name'];
          $det['app_id'] = $value['auto_id'];
          $det['apps_description'] = $value['apps_description'];
          if(!empty($AppsManagement['app_version'])){
          $get_start_date=date('M d Y',strtotime($AppsManagement['update_date']));
          $det['date'] = $get_start_date;
          }else{
           $det['date'] = "-" ; 
          }
          $det['upload_apk'] = $data."/backend/web/".$AppsManagement['upload_apk']; 
          if(!empty($AppsManagement['app_version'])){
          $det['app_version'] = $AppsManagement['app_version']; 
          }else{
            $det['app_version'] = 0;
          }
          $det1[]=$det;
        
        }
        $list['status']='success';
        $list['message']='success';
        $list['apps_list']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Apps List not Available';
        $list['apps_list']=array();
      }

}
   
}
}
$response['Output'][] = $list;
        
  return json_encode($response);
}

/*public function actionUploadApp()
{

  $data=Url::base(true);
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
 $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($model=$this->authorization()){
    
    $field_check=array('apk_key');
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
       
    }else{ 
      $apk_key = $requestInput['apk_key'];
      if($apk_key=="upload_details"){
        $UploadApp = UploadApp::find() 
          ->asArray()
          ->all();
           if(!empty($UploadApp)){
        foreach ($UploadApp as $key => $value) {
          $det['upload_apk'] = $data."/backend/web/".$value['upload_apk'];
          $det['upload_id'] = $value['upload_id'];
          $det['app_description'] = $value['app_description'];
          $det1[]=$det;
        }
        $list['status']='success';
        $list['message']='success';
        $list['apps_list']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Apps details not Available';
        $list['apps_list']=array();
      }

}
   
}
}
$response['Output'][] = $list;
        
  return json_encode($response);
}*/

     /*APP DETAILS*/
public function actionAppDetails()
{

  $data=Url::base(true);
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
 $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($model=$this->authorization()){
    
    $field_check=array('apk_key','app_id');
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
       
    }else{ 
 
      $apk_key = $requestInput['apk_key'];
      if($apk_key=="app_details"){
        $ClientPermission = ClientPermission::find() 
          ->orderBy(['app_id'=>SORT_DESC])
          ->asArray()
          ->one();
        $AppsManagement=AppsManagement::find()
            ->where(['auto_id'=>$requestInput['app_id']])
            ->asArray()
            ->one();
          $list['apps_logo'] = $data."/backend/web/".$AppsManagement['apps_logo'];
          $list['apps_name'] = $AppsManagement['apps_name'];
          $list['apps_description'] = $AppsManagement['apps_description'];
          $get_start_date=date('M d Y',strtotime($AppsManagement['create_date']));
          //$list['date'] = $get_start_date;
          $UploadApp=UploadApp::find()
            ->where(['upload_id'=>$requestInput['app_id']])
            ->asArray()
            ->orderBy(['update_date'=>SORT_DESC])
            ->all();
            $det1=array();
          //echo "<pre>";print_r($UploadApp);die;
           if(!empty($UploadApp)){
        $latest_data="";
        $latest_data1="";
        $latest_data2="";
        $io=0;
        foreach ($UploadApp as $key => $value) {
          //echo "<pre>"; print_r( $UploadApp);die;
          $get_start_date=date('M d Y',strtotime($value['create_date']));
          $det['date'] = $get_start_date;
          //$det['update_date'] =$value['update_date'];
          $det['upload_id'] = $value['upload_id'];
          $det['app_description'] = $value['app_description'];
          $det['app_version'] = $value['app_version'];
          $det['upload_apk'] = $data."/backend/web/".$value['upload_apk'];
          if ($io==0) {
          $latest_data = $data."/backend/web/".$value['upload_apk'];
          $latest_data1 = $value['upload_id'];
          $latest_data2 = $value['app_description'];
          $latest_data3 = $value['app_version'];
          $latest_data4 = $value['update_date'];
          }
          if($io!=0) {
            $det1[]=$det;
          }
          $io++;
        }

        $list['status']='success';
        $list['message']='success';
        $list['latest_apk']=$latest_data;
        $list['latest_id']=$latest_data1;
        $list['latest_description']=$latest_data2;
        $list['app_version']=$latest_data3;
        $list['date']=date('M d Y',strtotime($latest_data4));
        $list['apps_list']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Apps List not Available';
        $list['apps_list']=array();
      }

}
   
}
}
$response['Output'][] = $list;
        
  return json_encode($response);
}


/*MY PROFILE*/

public function actionMyProfile()
{

  $data=Url::base(true);
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($model=$this->authorization()){
        $client_id=$model->auto_id;  

    $field_check=array('apk_key');
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
       
    }else{ 
      $apk_key = $requestInput['apk_key'];
      if($apk_key=="my_profile"){
        $ClientManagement=ClientManagement::find()
          ->where(['auto_id'=>$client_id])
          ->asArray()
          ->all();
       if(!empty($ClientManagement)){
        foreach ($ClientManagement as $key => $value) {
          $det['Client Name'] = $value['client_name'];
          $det['Email Id'] = $value['email_id'];
          $det1[]=$det;
        }
        $list['status']='success';
        $list['message']='success';
        $list['profile']=$det1;
      }else{
        $list['status']='success';
        $list['message']='Profile List not Available';
        $list['profile']=array();
      }

}
   
}
}
$response['Output'][] = $list;
        
  return json_encode($response);
}

/*MY PROFILE UPDATE*/


public function actionProfileUpdate()
{

  $data=Url::base(true);
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($model=$this->authorization()){
        $client_id=$model->auto_id;  

    $field_check=array('client_name','email_id');
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
       
    }else{ 
        $client_name = $requestInput['client_name'];
        $email_id = $requestInput['email_id'];
        $ClientManagement=ClientManagement::find()
          ->where(['auto_id'=>$client_id])
          ->asArray()
          ->one();
       if(!empty($ClientManagement)){
         ClientManagement::updateAll(['email_id'=>$email_id,'client_name'=>$client_name],['auto_id'=>$ClientManagement['auto_id']]);
         $list['status']='success';
         $list['message']='Updated Successfully';
      }else{
        $list['status']='success';
        $list['message']='NOT Available';
      }
   
}
}
        
  return json_encode($list);
}

/*CHANGE PASSWORD*/

public function actionChangePassword()
{

  $data=Url::base(true);
   $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true); 
 
  $list['status'] = 'error';
  $list['message'] = 'Invalid Authorization Request!';
  
  if($model=$this->authorization()){
        $client_id=$model->auto_id;  

    $field_check=array('client_name','password_hash','old_password');
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 

    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
       
    }else{ 
        $client_name = $requestInput['client_name'];
        $password_hash = $requestInput['password_hash'];
        $old_password = $requestInput['old_password'];

        $ClientManagement=ClientManagement::find()
          ->where(['client_name'=>$client_name])
          ->asArray()
          ->one();

        if(!empty($ClientManagement)){
              //foreach ($ClientManagement as $key => $value){ 
            $haspassword=$ClientManagement['password_hash'];
         // echo "<pre>"; print_r($old_password);die;
              if(!empty($haspassword))
              {
                    if(Yii::$app->security->validatePassword($old_password,$haspassword))
                    { 
                      if($ClientManagement['client_name'] == $client_name)
                      {
                    if(!empty($password_hash))
                          {
                     $password_change=Yii::$app->security->generatePasswordHash($password_hash);
                        ClientManagement::updateAll(['password_hash'=>$password_change],['client_name'=>$client_name]);
                        $list['status']='success';
                        $list['message']='Updated Successfully';                          }
                          else
                          {
                              $list['status'] = "not exist";
                               $list['message']='Invalid';   
                          }
                      }
                      else
                      {
                          $list['status'] = "not exist";
                           $list['message']='Invalid';   
                      }
                  }
                  else
                  {

                      $list['status'] = "not exist";
                       $list['message']='Invalid';   
                  }
              }
               else
                  {

                      $list['status'] = "not exist";
                       $list['message']='Invalid';   
                  }
       // }
      }
        else
        {
            $list['error'] = "not exist";
             $list['message']='Invalid';   
        }
   
}
}
        
  return json_encode($list);
}




 

}
