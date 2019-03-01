<?php

namespace app\controllers;

use app\models\resetPassword;
use app\models\SignUp;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Userdb;
use yii\helpers\Html;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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

    /**
     * {@inheritdoc}
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
     * @return string
     */
    public function actionIndex()
    {
//        echo '<pre>';
//        echo 123;
//        print_r();
//        echo '</pre>';
//        if (Yii::$app->user->identity->status !== 20) {
//            return $this->render('error', ['message' => 'У вас нет доступа']);
//        }
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) { //load - встановити властивості моделі  $_POST==Yii::$app->request->post()
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword()
    {
        $model = new resetPassword();

        $showForm = true;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->resetPassword()) {
                Yii::$app->session->setFlash('success', 'link to reset password has been send, check your email');
                $showForm = false;
            } else {
                Yii::$app->session->setFlash('error', 'Cant find such email');

            }
        }

        return $this->render('userResetPassword', [
            'model' => $model,
            'showForm' => $showForm
        ]);

    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignUp()
    {
        $data = new SignUp();

        if ($data->load(Yii::$app->request->post()) && $data->SignUp()) {
            Yii::$app->session->setFlash('success', 'ty 4 registration');
//            Yii::$app->
        }
        $data->password = '';
        $data->confirmPassword = '';

        return $this->render('signup', ['model' => $data]);
    }
}
