<?php

namespace backend\controllers;

use Yii;
use backend\models\UploadApp;
use backend\models\UploadAppSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use backend\models\ClientPermission;
use backend\models\AppsManagement;
use backend\models\Notification;
use backend\models\ClientManagement;
use yii\filters\AccessControl;

/**
 * UploadAppController implements the CRUD actions for UploadApp model.
 */
class UploadAppController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
   {
       return [
           'verbs' => [
               'class' => VerbFilter::className(),
               'actions' => [
                   'delete' => ['post'],
               ],
           ],
         'access' => [
           'class' => AccessControl::className(),
           'rules' => [
               [
                   'allow' => true,
                   'roles' => ['@'],
               ],
               // ...
           ],
       ],
       ];
   }

    /**
     * Lists all UploadApp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UploadAppSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UploadApp model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UploadApp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UploadApp();

       /* if ($model->load(Yii::$app->request->post()) && $model->save()) {
       return $this->redirect(['index']); 
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
      

        if ($model->load(Yii::$app->request->post())) {
          //echo "<pre>";  print_r($_POST);die;
        $upload_id=$_POST['UploadApp']['upload_id'];

            if($_FILES){

            if ($_FILES['UploadApp']['error']['upload_apk'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'upload_apk');
                    $image_name = 'apk/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->upload_apk = $image_name;
                    $model->upload_id= $upload_id;
          if($model->save()){
        $ClientPermission=ClientPermission::find()
            ->where(['app_id'=>$upload_id])
            ->asArray()
            ->all();
        $upload_app=AppsManagement::find()
            ->where(['auto_id'=>$upload_id])
            ->asArray()
            ->one();
            $apps_name=$upload_app['apps_name'];
        $ClientPermission_map=ArrayHelper::map($ClientPermission,'client_id','client_id');
        $Client_management=ClientManagement::find()->where(['IN','auto_id',$ClientPermission_map])->asArray()->all();
       
        $ClientPermission_index=ArrayHelper::index($ClientPermission,'client_id');



        if(!empty($Client_management))
        {
            foreach ($Client_management as $key => $value) 
            {
                    $app_id='';
                    if(array_key_exists($value['auto_id'], $ClientPermission_index))
                    {
                        $app_id=$ClientPermission_index[$value['auto_id']]['app_id'];
                    }

                    $msg_1 = array("title" =>ucwords($apps_name),"message"=>ucwords($apps_name)." new update is now available for download.","app-id"=>$app_id); 
                    $fields = array("registration_ids" => [$value['notification_id']], 'data' => $msg_1);

                    $url = 'https://fcm.googleapis.com/fcm/send';
                      
                    $apikey="AAAAzuLp014:APA91bGy5Ae9mnlIHgYzx-tvcKjB_Vqdem26IDOevVaCC_M4KsWxKmMK32GAnCs2lkDkIYQjTJWYss8mXLaAh03vm-engMX9sNxXqTPGxnaAAECP6p9dAk4Sg2CABWWhsWxsApvlKm5b";
                   //building headers for the request
                    $headers = array('Authorization: key=' . $apikey, 'Content-Type: application/json');
                   //Initializing curl to open a connection
                   $ch = curl_init();
                   //Setting the curl url
                   curl_setopt($ch, CURLOPT_URL, $url);
                   //setting the method as post
                   curl_setopt($ch, CURLOPT_POST, true);
                   //adding headers
                   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                   //disabling ssl support
                   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                   //adding the fields in json format
                   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

                   //finally executing the curl request
                   $result = curl_exec($ch);
                   //print_r($result);die;
                   if ($result === FALSE) {
                       die('Curl failed: ' . curl_error($ch));
                        
                   }
                    //echo $result;die;
                    //Now close the connection
                   curl_close($ch);
            }
        }
       //and return the result
return $this->redirect(['index']); 
                 }  
            }
            }

            
            
        } else {
            $applist=ArrayHelper::map(AppsManagement::find()->all(), 'auto_id', 'apps_name');
            return $this->render('create', [
                'model' => $model,
                'applist'=>$applist,
            ]);
        }


    }

    /**
     * Updates an existing UploadApp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
         $upload_id=$id;
        $model = $this->findModel($id);

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']); 
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/

       $applist=ArrayHelper::map(AppsManagement::find()->all(), 'auto_id', 'apps_name');

            if ($model->load(Yii::$app->request->post())) {

                if($_FILES['UploadApp']['name']['upload_apk'] !='' ){

                if ($_FILES['UploadApp']['error']['upload_apk'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'upload_apk');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->upload_apk = $image_name;
                    $model->upload_id= $upload_id;
                   // $model->app_version= $app_version;

            }
            }

        if($_FILES['UploadApp']['name']['upload_apk'] !=''){
            $upload_apk=$image_name;
            }
            else{
            $upload_apk="";
            }
            $app_description=$_POST['UploadApp']['app_description'];
            $app_version=$_POST['UploadApp']['app_version'];
            //echo "<pre>";print_r($_POST);die;
            //$upload_id=$_POST['UploadApp']['auto_id'];

            if($upload_apk!=''){
             $command = Yii::$app->db->createCommand("UPDATE upload_app SET upload_apk='$upload_apk', app_description='$app_description', app_version='$app_version' WHERE auto_id=".$upload_id);
              $command->execute();
              }
              else{
               $command = Yii::$app->db->createCommand("UPDATE upload_app SET app_description='$app_description' , app_version='$app_version' WHERE auto_id=".$upload_id);
              $command->execute();
              }

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                 'applist'=>$applist,
            ]);
        }

    }

    /**
     * Deletes an existing UploadApp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UploadApp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UploadApp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UploadApp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
