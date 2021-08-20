<?php

namespace app\controllers;

use app\models\MessageForm;
use Yii;
use yii\base\BaseObject;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrationForm;
use app\models\User;
use app\models\UserListForm;
use app\models\MessageSave;

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

    public function debug($arr)
    {
        echo '<pre>'.print_r($arr, true).'</pre>';
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
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
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new RegistrationForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->username = $model->username;
            $user->password = Yii::$app->security->generatePasswordHash($model->password);

            if($user->save()){
                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }
        return $this->render('registration', compact('model'));
    }

    public function actionUsers()
    {
        $userlist = UserListForm::find()->all();

        return $this->render('users', ['userlist' => $userlist]);
    }

    public function actionMessage()
    {
        $model = new MessageForm();


        $userid = Yii::$app->request->get('id');
        $myid = Yii::$app->user->id;

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $modelsave = new MessageSave();
            $modelsave->userto = $model->userto;
            $modelsave->userfrom = $myid;
            $modelsave->messagetext = $model->messagetext;
            //$this->debug($modelsave);
            $modelsave->save();
        }


        $messages = (new Query())->from('message')->where(
            ['OR',
                ['AND',['userfrom'=>$userid], ['userto'=>$myid]],
                ['AND',['userfrom'=>$myid], ['userto'=>$userid]]])->all();
        $userto = UserListForm::find()->select('username')->where(['id'=>$userid])->asArray()->one();
        //$messages = MessageForm::find()->all();
        return $this->render('message', ['userto'=>$userto, 'userid' => $userid, 'messages' => $messages, 'model' => $model]);
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
