<?php

namespace backend\controllers;

use Yii;
use backend\models\AppsManagement;
use backend\models\AppsManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AppsManagementController implements the CRUD actions for AppsManagement model.
 */
class AppsManagementController extends Controller
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
     * Lists all AppsManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppsManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppsManagement model.
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
     * Creates a new AppsManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppsManagement();
        if ($model->load(Yii::$app->request->post())) {

            if ($_FILES['AppsManagement']['error']['apps_logo'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'apps_logo');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->apps_logo = $image_name;
            }
             if ($_FILES['AppsManagement']['error']['company_logo'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'company_logo');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->company_logo = $image_name;
            }
            if ($model->save()) {
                //Yii::$app->getSession()->setFlash('success', 'Category Saved successfully.');
                   return $this->redirect(['index']); } 
                   else {
                //    Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
                     return $this->render('create', [
                'model' => $model,
            ]);
                }
          
        } 
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing AppsManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
       $Appsid=$id;
        if ($model->load(Yii::$app->request->post())) {

              $apps_name=$_POST['AppsManagement']['apps_name'];
              $apps_description=$_POST['AppsManagement']['apps_description'];
              $company_name=$_POST['AppsManagement']['company_name'];
             if ($_FILES['AppsManagement']['error']['apps_logo'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'apps_logo');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $apps_logo = $image_name;
              }else{
                $apps_logo="";
              }
             if ($_FILES['AppsManagement']['error']['company_logo'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'company_logo');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $company_logo = $image_name;
              }else{
                $company_logo="";
              }
              if(!empty($apps_logo) && !empty($company_logo)){
             $command = Yii::$app->db->createCommand("UPDATE apps_management SET apps_logo='$apps_logo', apps_name='$apps_name', apps_description='$apps_description',company_name='$company_name',company_logo='$company_logo' WHERE auto_id=".$Appsid);
              $command->execute();
              }else if(!empty($apps_logo)){

                $command = Yii::$app->db->createCommand("UPDATE apps_management SET apps_logo='$apps_logo', apps_name='$apps_name', apps_description='$apps_description',company_name='$company_name' WHERE auto_id=".$Appsid);
              $command->execute();

              }
              else if(!empty($company_logo)){
                $command = Yii::$app->db->createCommand("UPDATE apps_management SET apps_name='$apps_name', apps_description='$apps_description',company_name='$company_name',company_logo='$company_logo' WHERE auto_id=".$Appsid);
              $command->execute();
              }
              else{

                  $command = Yii::$app->db->createCommand("UPDATE apps_management SET apps_name='$apps_name', apps_description='$apps_description',company_name='$company_name' WHERE auto_id=".$Appsid);
              $command->execute();
              }
              
            
              return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Deletes an existing AppsManagement model.
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
     * Finds the AppsManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppsManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppsManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
