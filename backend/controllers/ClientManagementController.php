<?php

namespace backend\controllers;

use Yii;
use backend\models\ClientManagement;
use backend\models\ClientManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\Notification;
use backend\models\AppsManagement;
use backend\models\ClientPermission;
use yii\filters\AccessControl;
/**
 * ClientManagementController implements the CRUD actions for ClientManagement model.
 */
class ClientManagementController extends Controller
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
     * Lists all ClientManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientManagement model.
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
     * Creates a new ClientManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClientManagement();
        $applist=ArrayHelper::map(AppsManagement::find()->all(), 'auto_id', 'apps_name');
       

        if ($model->load(Yii::$app->request->post())) {
   // echo "<pre>";  print_r(Yii::$app->request->post());die;
        $password_hash=Yii::$app->request->post('ClientManagement')['password_hash'];
        $model->password_hash = Yii::$app->security->generatePasswordHash($password_hash);
           $model->auth_key = Yii::$app->security->generateRandomString();
         if($model->save()){
            $client_id=$model->auto_id;
           $check= Yii::$app->request->post('ClientManagement')['apps_name'];
         //  print_r($check);die;
          foreach ($check as $key => $value) {
             $model1= new ClientPermission();
               $model1->client_id=$client_id;
               $model1->app_id=$value;
                if(!$model1->save()){
            echo "<pre>";   print_r($model->getErrors());
              }
           }
            }else{
                print_r($model->getErrors());
            }
            return $this->redirect(['index']); 
        } else {
            return $this->render('create', [
                'model' => $model,
                'applist'=>$applist,
               // 'model1'=>$model1,

            ]);
        }
    }

    /**
     * Updates an existing ClientManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
      $applist=ArrayHelper::map(AppsManagement::find()->all(), 'auto_id', 'apps_name');
        //$model1= new ClientPermission();
        $model1 = ClientPermission::find()
        ->where(['client_id'=> $id ])
        ->asArray()
        ->all();
       // print_r($model1);die;
        if ($model->load(Yii::$app->request->post())) {
           // echo "<pre>"; print_r($_POST);die;
        $password_hash=Yii::$app->request->post('ClientManagement')['password_hash'];
        if(!empty($password_hash)){
            $model->password_hash = Yii::$app->security->generatePasswordHash($password_hash);
         }else{
            $model21 = ClientManagement::find()
        ->where(['auto_id'=> $id ])
        ->asArray()
        ->one();
        $password_hash=$model21['password_hash'];   
         $model->password_hash=$password_hash;    
         }
       
           //$model->auth_key = Yii::$app->security->generateRandomString();

         if($model->save()){
            $client_id=$model->auto_id;
           $check= Yii::$app->request->post('ClientManagement')['apps_name'];
              // echo "<pre>"; print_r($_POST);die;
           ClientPermission::deleteAll(['client_id' =>$id]);
           if(!empty($check)){
            foreach ($check as $key => $value) {
                $model1 = new ClientPermission();
               $model1->client_id=$client_id;
               $model1->app_id=$value;
                if(!$model1->save()){
            echo "<pre>";   print_r($model->getErrors());
              }
           }
           }
            }else{
                print_r($model->getErrors());
            }
            return $this->redirect(['index']); 
        } else {
            return $this->render('update', [
                'model' => $model,
                'applist'=>$applist,
                'model1' =>$model1,

            ]);
        }
    }
    /**
     * Deletes an existing ClientManagement model.
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
     * Finds the ClientManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
