<?php

namespace app\controllers;

use app\models\ChangeEmails;
use app\models\ChangePhones;
use app\models\Emailhash;
use app\models\Users;
use app\models\Resize;
use app\models\Objects;
use app\models\Smshash;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

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
                'only' => ['logout', 'add-object'],
                'rules' => [
                    [
                        'actions' => ['logout', 'add-object'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['add-object'],
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
                            Yii::$app->session->setFlash('warning', 'Необходимо авторизоваться');
                            return $action->controller->redirect(['site/login']);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get', 'post'],
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
        $searchModel = new \app\models\ObjectsSearch();
        $objectsProvider = $searchModel->search(Yii::$app->request->queryParams);
        // print_r(Yii::$app->request->queryParams);exit;
        return $this->render('index', compact('searchModel', 'objectsProvider'));
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionAddObject()
    {
        $model = new Objects();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {

            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');

            if ($model->upload()) {

                $images = [];

                foreach ($model->imageFiles as $file) {
                    $resize = \Yii::$app->Resize->load(Yii::getAlias('@webroot') .'/uploads/'. $file->name)
                        ->resizeAuto(1920)
                        ->setRandName()
                        ->save(false);
                    $images[] = $resize;
                    unlink(Yii::getAlias('@webroot') .'/uploads/'. $file->name);

                    $model->imageFiles = '';
                    $model->photos = json_encode($images);
                }

                if ($model->save()) {
                    return $this->redirect(['/catalog/view', 'id' => $model->id]);
                } else {
                    foreach ($model->getErrors() as $key => $value) {
                        \Yii::$app->session->setFlash('error', $value);
                    }
                }

            }
        }

        return $this->render('add_objects', [
            'model' => $model,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionUpdateObject($id)
    {
        $model = Objects::findOne($id);

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');

            if ($model->upload()) {

                $model->removeOldPhotos();

                $images = [];
                foreach ($model->imageFiles as $file) {
                    $resize = \Yii::$app->Resize->load(Yii::getAlias('@webroot') .'/uploads/'. $file->name)
                        ->resizeAuto(1920)
                        ->setRandName()
                        ->save(false);
                    $images[] = $resize;
                    unlink(Yii::getAlias('@webroot') .'/uploads/'. $file->name);
                }

                $model->imageFiles = '';
                $model->photos = json_encode($images);
                if ($model->save()) {
                    return $this->redirect(['/catalog/view', 'id' => $model->id]);
                } else {
                    foreach ($model->getErrors() as $key => $value) {
                        \Yii::$app->session->setFlash('error', $value);
                    }
                }

            }
        }

        return $this->render('add_objects', [
            'model' => $model,
        ]);
    }

    /**
     * PasswordRecovery action.
     *
     * @return string|Response
     */

    public function actionPasswordRecoveryStep1()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $email = Yii::$app->request->get('email');

        $model = new LoginForm();
        $model->scenario = LoginForm::SCENARIO_PASSWORD_RECOVERY_STEP1;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $user = Users::find()->where(['phone' => $model->phone])->one();
            $email_code = Yii::$app->Email->setHash($user->id, Emailhash::PASSWORD_RECOVERY);
            Yii::$app->getSession()->setFlash('success', 'Вам отправлено письмо на E-mail (' . $user->email . ') для сменя пароля.');

            $label = 'Восстановление пароля';
            $text = 'Для восстановления пароля, перейдите по <a href="' . Yii::$app->params['domain'] . '/site/password-recovery-step-2?hash=' . $email_code . '">ссылке</a>';
            Yii::$app->Email->send($user->email, $label, $text, ChangeEmails::TYPE_NO_REPLY);

            return $this->goHome();
        }

        return $this->render('login/password-recovery-step-1', [
            'model' => $model,
            'email' => $email
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionPasswordRecoveryStep2()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $hash = Yii::$app->request->get('hash');

        $model = new LoginForm();
        $model->scenario = LoginForm::SCENARIO_PASSWORD_RECOVERY_STEP2;
        $hashModel = Emailhash::find()->where(['AND', ['=', 'hash', $hash], ['=', 'type', Emailhash::PASSWORD_RECOVERY]])->one();

        if (!$hashModel) {
            Yii::$app->getSession()->setFlash('success', 'Ссылка для смены пароля не корректна.');
            return $this->render('login/password-recovery-step-2', [
                'model' => $model
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = Users::findOne($hashModel->user_id);

            $user->setPassword($model->password);
            $user->save();
            $hashModel->delete();

            Yii::$app->user->login(Users::findOne(['id' => $user->id]));
            $this->goHome();
        }

//        $temporary_id = Yii::$app->session->get('temporary_id');
//
//        if (empty($temporary_id)) {
//            \Yii::$app->getSession()->setFlash('error', 'ID is EMPTY');
//            return $this->goBack();
//        }
//
//        if (!$user = Users::find($temporary_id)->one()) {
//            \Yii::$app->getSession()->setFlash('error', 'User is not found');
//            return $this->goBack();
//        }
//
//        $model = new LoginForm();
//        $model->scenario = LoginForm::SCENARIO_PASSWORD_RECOVERY_STEP2;
//        $model->phone = $user->phone;
//
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $code = Smshash::find()
//                ->where(['type' => Smshash::PASSWORD_RECOVERY])
//                ->andWhere(['user_id' => $temporary_id])
//                ->andWhere(['hash' => $model->code])
//                ->one();
//
//            if ($code) {
//                $user->setPassword($model->password);
//                $user->save();
//                $code->delete();
//
//                Yii::$app->user->login(Users::findOne(['id' => $user->id]));
//                $this->goHome();
//            } else {
//                $model->addError('code', 'Code is not correct');
//                $model->password = '';
//                $model->password_repeat = '';
//                return $this->render('login/password-recovery-step-2', [
//                    'model' => $model,
//                ]);
//            }
//        }

        $model->password = '';
        $model->password_repeat = '';

        return $this->render('login/password-recovery-step-2', [
            'model' => $model,
        ]);
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
        $model->scenario = LoginForm::SCENARIO_LOGIN;
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->addError('password', 'Login or password is incorrect');
        }

        $model->password = '';
        return $this->render('login/login', [
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
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm(['scenario' => LoginForm::SCENARIO_REGISTRATION_EMAIL]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $params = Yii::$app->request->post('LoginForm');

            $user = new Users();
            $user->email = $model->email;
            $user->login = $model->login;
            $user->setPassword($model->password);

            if ($user->save()) {
                $email_code = Yii::$app->Email->setHash($user->id, Emailhash::EMAIL_ACTIVE);
                $label = 'Подтверждение E-mail адреса';
                $text = 'Для подтверждения E-mail адреса, перейдите по <a href="' . Yii::$app->params['domain'] . '/cabinet/email-hash?hash=' . $email_code . '">ссылке</a>';
                Yii::$app->Email->send($user->email, $label, $text, ChangeEmails::TYPE_NO_REPLY);
                Yii::$app->getSession()->setFlash('success', 'Вам отправлено письмо на E-mail ' . $user->email . ' для подтверждения E-mail.');

                $login = new LoginForm();
                $login->scenario = LoginForm::SCENARIO_LOGIN;
                if ($login->load(Yii::$app->request->post()) && $login->login()) {
                    return $this->redirect(['cabinet/profile-edit']);
                }
            }
            return $this->goBack();
        }

        return $this->render('login/registration-email', [
            'model' => $model,
        ]);
    }

    public function actionRegistrationPhone()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm(['scenario' => LoginForm::SCENARIO_REGISTRATION_STEP1]);

        $user = false;
        if ($temporary_id = Yii::$app->session->get('temporary_id')) {
            $user = Users::findOne($temporary_id);
            $model->phone = $user->phone;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $params = Yii::$app->request->post('LoginForm');

            if (!$user) {
                $user = new Users();
            }

            $user->phone = $params['phone'];
            // $user->login = '';

            if ($user->save()) {

                if ($code = Smshash::find()
                    ->where(['type' => Smshash::NEW_USER])
                    ->andWhere(['user_id' => $temporary_id])
                    ->one()
                ) {
                    $code->delete();
                }

                $sms = new Smshash();
                $sms->user_id = $user->id;
                $sms->type = Smshash::NEW_USER;
                $sms->hash = Smshash::generate();
                $sms->save();
                // echo $sms->hash;
                // return 0;
                Yii::$app->SMS->send($user->phone, 'Your code: ' . $sms->hash);
                Yii::$app->session->set('temporary_id', $user->id);

                return $this->redirect(['site/registration-step-2']);
            }

            return $this->goBack();
        }

        return $this->render('login/registration-step-1', [
            'model' => $model,
        ]);
    }

    public function actionRegistrationStep2()
    {
        $temporary_id = Yii::$app->session->get('temporary_id');

        if (empty($temporary_id)) {
            \Yii::$app->getSession()->setFlash('error', 'ID is EMPTY');
            return $this->goBack();
        }

        if (!$user = Users::find($temporary_id)->one()) {
            \Yii::$app->getSession()->setFlash('error', 'User is not found');
            return $this->goBack();
        }

        $model = new LoginForm(['scenario' => LoginForm::SCENARIO_REGISTRATION_STEP2]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $code = Smshash::find()
                ->where(['type' => Smshash::NEW_USER])
                ->andWhere(['user_id' => $temporary_id])
                ->andWhere(['hash' => $model->code])
                ->one();

            if ($code) {
                $user->login = $model->login;
                $user->setPassword($model->password);
                $user->save();
                $code->delete();

                Yii::$app->user->login(Users::findOne(['id' => $user->id]));
                $this->goHome();
            } else {
                $model->addError('code', 'Code is not correct');
                $model->password = '';
                $model->password_repeat = '';
                return $this->render('login/registration-step-2', [
                    'model' => $model,
                ]);
            }
        }

        $model->password = '';
        $model->password_repeat = '';
        return $this->render('login/registration-step-2', [
            'model' => $model,
            'user' => $user
        ]);
    }
}
