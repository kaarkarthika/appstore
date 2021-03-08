<?php
namespace frontend\controllers;
error_reporting(E_ALL ^ E_NOTICE);
use Yii;
use common\models\FrontendLoginForm;
use common\models\Frontend;
use backend\models\CustomersProfile;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SwimCustomer;
use frontend\models\SwimCustomerSearch;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use backend\models\ClientManagement;
use backend\models\Notification;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
   public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
}
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
    
          return $this->redirect('backend/web/index.php');
    } 
    public function actionDashboard()
    {
        $searchModel = new SwimCustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	
	 // $cx=Yii::$app->user->identity->branch_autoid;
// print_r($cx);die;
        return $this->render('dashboard', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
      
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        /*if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'loginLayout';

        $model = new FrontendLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
           return $this->redirect(['index.php/dashboard']);
            //return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }*/
		
        $list = array();
  $postd=(Yii::$app ->request ->rawBody);
  $requestInput = json_decode($postd,true);
  $model=new ClientManagement();
  $list['status'] = 'error';
  $list['message'] = 'Nill';
    
    $field_check=array('username','password','notification_id');
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
    $super_data = ClientManagement::find()
          ->where(['email_id'=>$requestInput['username']])
          ->one();
    $loginkey='';
    $login_status="S";
    $list['login_key'] = "";
    if(!empty($super_data)){ 
      $password=$requestInput['password'];
       $haspassword=$super_data->password_hash;
    if(Yii::$app->security->validatePassword($password,$haspassword)){
       $notification_id=$requestInput['notification_id'];
        if(!empty($notification_id)){
        $super_data->notification_id=$notification_id;
        $super_data->save();
      }
        $location[0]='';
        $location[1]=''; 
        $list['status'] = "success";
        $list['message'] = "Logged In successfully"; 
        $list['login_key'] = "S";
        $list['login_name']= $requestInput['username'];
        $list['client_id'] =$super_data->auto_id;
        $list['auth_key']= $super_data->auth_key; 
        $list['client_name']= $super_data->client_name; 
        $list['login_unique_key']= 'client_name';
        $loginkey="S";
      }else{
        $list['message'] = 'Invalid Login';
        $login_status="F";
      }
    }
        $response['Output'][] = $list;
        return json_encode($response);
		
   }
}

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        $session = Yii::$app->session;
        $session->destroy();

         return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
	public function actionNews()
    {
        return $this->render('news');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
