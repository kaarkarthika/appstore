<?php

namespace backend\controllers;
error_reporting(E_ALL ^ E_NOTICE);
use Yii;
use common\models\User;
use backend\models\Userdetails;
use backend\models\UserdetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * UserdetailsController implements the CRUD actions for Userdetails model.
 */
class UserdetailsController extends Controller
{
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
     * Lists all Userdetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserdetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Userdetails model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionView1($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Userdetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Userdetails();
        if ($model->load(Yii::$app->request->post())) {
            //if ($user = $model->signup()) {
         //echo "<pre>";    print_r($_POST);die;
                /* if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                } */
           $password_hash=Yii::$app->request->post('Userdetails')['password_hash'];
           $model->password_hash = Yii::$app->security->generatePasswordHash($password_hash);
           $model->auth_key = Yii::$app->security->generateRandomString();
           $model->user_level="2";
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', 'User details has been created successfully.');				
                return $this->redirect(['index']);
            }else{
            echo "<pre>";print_r($model->getErrors());die;
        }
       // }
    }else{
      // Yii::$app->getSession()->setFlash('error', 'Something went wrong !');

    }

        return $this->render('create', [
            'model' => $model,
        ]);
      
    }

    /**
     * Updates an existing Userdetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
 public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
        
        $model->first_name=$_POST['Userdetails']['first_name'];
        $model->last_name=$_POST['Userdetails']['last_name'];
        $model->designation=$_POST['Userdetails']['designation'];
        $model->mobile_number=$_POST['Userdetails']['mobile_number'];
        $model->city=$_POST['Userdetails']['city'];
        $model->user_type=$_POST['Userdetails']['user_type'];
        $model->username=$_POST['Userdetails']['username'];
        $model->user_level="2";
        $password_hash=Yii::$app->request->post('Userdetails')['password_hash'];
        if(!empty($password_hash)){
            $model->password_hash = Yii::$app->security->generatePasswordHash($password_hash);
         }else{
            $model21 = Userdetails::find()
        ->where(['id'=> $id ])
        ->asArray()
        ->one();
        $password_hash=$model21['password_hash'];   
         $model->password_hash=$password_hash;    
         }

        if($model->save()){
      Yii::$app->getSession()->setFlash('success', 'Admin details has been updated successfully.');
            return $this->redirect(['view','id' => $id]);
        }else{
            echo "<pre>";print_r($model->getErrors());die;
        }
        
        } else {
            // Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
        }
        return $this->render('update', [
                'model' => $model,
            ]);
    }
   /* public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'User details has been updated successfully.');
            return $this->redirect(['index']);
        } else {
            // Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
        }
        return $this->render('update', [
                'model' => $model,
            ]);
    }*/

    /**
     * Deletes an existing Userdetails model.
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
     * Finds the Userdetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userdetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userdetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
