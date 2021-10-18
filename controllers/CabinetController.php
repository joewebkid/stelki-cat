<?php

namespace app\controllers;

use app\models\Emailhash;
use app\models\Messages;
use app\models\HelpForm;
use app\models\Users;
use app\models\Objects;
use app\models\Smshash;
use app\models\ChangePhones;
use app\models\ChangeEmails;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class CabinetController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'profile-edit', 'messages', 'clear-change-phone', 'clear-change-email'],
                'rules' => [
                    [
                        'actions' => ['index', 'profile-edit', 'messages', 'clear-change-phone', 'clear-change-email'],
                        'allow' => true,
                        'roles' => ['@'],
                        'denyCallback' => function ($rule, $action) {
                            Yii::$app->session->setFlash('warning', 'Необходимо авторизоваться');
                            return $action->controller->redirect(['site/login']);
                        }
                    ],
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
        $user = Users::findOne(Yii::$app->user->getId());

        $searchModel = new \app\models\ObjectsSearch();
        $objectsProvider = $searchModel->search([
            'ObjectsSearch' => [
                'user_id' => Yii::$app->user->id,
            ]
        ]);
        return $this->render('index', compact(
            'user',
            'objectsProvider'
        ));
    }

    public function actionClearChangeEmail()
    {
        $email_change = ChangeEmails::find()->where(['=', 'user_id', Yii::$app->user->id])->one();
        $email_hash = Emailhash::find()->where(['type' => Emailhash::EMAIL_CHANGE])->andWhere(['user_id' => Yii::$app->user->id])->one();

        $email_change->delete();
        $email_hash->delete();

        Yii::$app->getSession()->setFlash('success', 'Смена E-mail отменена.');
        return $this->redirect(['cabinet/profile-edit']);
    }

    public function actionClearChangePhone()
    {
        $phone_change = ChangePhones::find()->where(['=', 'user_id', Yii::$app->user->id])->one();
        $phone_hash = Smshash::find()->where(['type' => Smshash::PHONE_CHANGE])->andWhere(['user_id' => Yii::$app->user->id])->one();

        $phone_change->delete();
        $phone_hash->delete();

        Yii::$app->getSession()->setFlash('success', 'Смена телефонного номера отменена.');
        return $this->redirect(['cabinet/profile-edit']);
    }

    public function actionProfileEdit()
    {
        $section = Yii::$app->request->get('section');
        $user = Users::findOne(Yii::$app->user->id);
        $phone_change = ChangePhones::find()->where(['=', 'user_id', $user->id])->one();
        $email_change = ChangeEmails::find()->where(['=', 'user_id', $user->id])->one();

        $model_phone = new LoginForm(['phone' => $user->phone]);
        if ($phone_change) {
            $model_phone->scenario = LoginForm::SCENARIO_PROFILE_EDIT_PHONE_STEP2;
        } else {
            $model_phone->scenario = LoginForm::SCENARIO_PROFILE_EDIT_PHONE_STEP1;
        }
        $model_email = new LoginForm(['email' => $user->email]);
        $model_email->scenario = LoginForm::SCENARIO_PROFILE_EDIT_EMAIL;
        $model_password = new LoginForm();
        $model_password->scenario = LoginForm::SCENARIO_PROFILE_EDIT_PASSWORD;

        $model_any = new LoginForm([
            'login' => $user->login,
            'sms_newsletter' => $user->sms_newsletter,
            'email_newsletter' => $user->email_newsletter
        ]);
        $model_any->scenario = LoginForm::SCENARIO_PROFILE_EDIT_ANY;

        if ($section == 'phone') {
            if ($model_phone->load(Yii::$app->request->post()) && $model_phone->validate()) {

                if ($model_phone->phone === $user->phone && empty($model_phone->code)) {
                    Yii::$app->getSession()->setFlash('warning', 'Вы не можете изменить телефон на существующий.');
                    return $this->redirect(['cabinet/profile-edit']);
                }

                $user->phone = $model_phone->phone;
                $user->save();
                Yii::$app->getSession()->setFlash('success', 'Ваш номер телефона изменен.');

//                if ($model_phone->code) {
//
//                    if (Yii::$app->SMS->getHash($user->id, Smshash::PHONE_CHANGE, $model_phone->code)) {
//
//                        $ch_phone = ChangePhones::find()->where(['=', 'user_id', $user->id])->one();
//
//                        Yii::$app->SMS->deleteHash($user->id, Smshash::PHONE_CHANGE, $model_phone->code);
//                        $user->phone = $ch_phone->phone;
//                        $user->save();
//
//                        foreach (ChangePhones::find()->where(['=', 'user_id', $user->id])->all() as $changes) {
//                            $changes->delete();
//                        }
//
//                        Yii::$app->getSession()->setFlash('success', 'Ваш номер телефона изменен.');
//                        return $this->redirect(['cabinet/profile-edit']);
//                    } else {
//                        Yii::$app->getSession()->setFlash('danger', 'Код из SMS-сообщения не верен.');
//                        return $this->redirect(['cabinet/profile-edit']);
//                    }
//                }
//
//                foreach (ChangePhones::find()->where(['=', 'user_id', $user->id])->all() as $changes) {
//                    $changes->delete();
//                }

//                $newChange = new ChangePhones();
//                $newChange->user_id = $user->id;
//                $newChange->phone = $model_phone->phone;
//                $newChange->save();

//                $sms_code = Yii::$app->SMS->setHash($user->id, Smshash::PHONE_CHANGE);
//                Yii::$app->SMS->send($model_phone->phone, 'Your code: ' . $sms_code);
//                Yii::$app->getSession()->setFlash('success', 'Вам отправлено SMS-сообщение на номер "' . $model_phone->phone . '" для подтверждение смены телефона.');
                return $this->redirect(['cabinet/profile-edit']);
            }
        }

        if ($section == 'email') {
            if ($model_email->load(Yii::$app->request->post()) && $model_email->validate()) {

                if ($model_email->email == $user->email) {
                    Yii::$app->getSession()->setFlash('warning', 'Вы не можете изменить E-mail на существующий.');
                    return $this->redirect(['cabinet/profile-edit']);
                }

                foreach (ChangeEmails::find()->where(['=', 'user_id', $user->id])->all() as $changes) {
                    $changes->delete();
                }

                $newChange = new ChangeEmails();
                $newChange->user_id = $user->id;
                $newChange->email = $model_email->email;
                $newChange->save();

                $email_code = Yii::$app->Email->setHash($user->id, Emailhash::EMAIL_CHANGE);
                Yii::$app->getSession()->setFlash('success', 'Вам отправлено письмо на E-mail ' . $model_email->email . ' для подтверждения смены.');

                self::sendCheckEmailMessage($model_email->email, $email_code);

                return $this->redirect(['cabinet/profile-edit']);
            }
        }

        if ($section == 'password') {
            if ($model_password->load(Yii::$app->request->post()) && $model_password->validate()) {

                $old_password_hash = $user->pwhash;
                $user->setPassword($model_password->password_old);
                $new_password_hash = $user->pwhash;

                if ($old_password_hash == $new_password_hash) {
                    $user->setPassword($model_password->password);
                    $user->save();
                    Yii::$app->getSession()->setFlash('success', 'Ваш пароль успешно изменен.');
                    return $this->redirect(['cabinet/profile-edit']);
                } else {
                    \Yii::$app->getSession()->setFlash('danger', 'Введеный Вами и указанный ранее пароль не совпадают.');
                    return $this->redirect(['cabinet/profile-edit']);
                }
            }
        }

        if ($section == 'any') {
            if ($model_any->load(Yii::$app->request->post()) && $model_any->validate()) {
                $user->login = $model_any->login;
                $user->email_newsletter = $model_any->email_newsletter;
                $user->sms_newsletter = $model_any->sms_newsletter;
                $user->save();
                Yii::$app->getSession()->setFlash('success', 'Ваши настройки изменены');
                return $this->redirect(['cabinet/profile-edit']);
            }
        }

        return $this->render('profile-edit', [
            'user' => $user,
            'model_phone' => $model_phone,
            'model_email' => $model_email,
            'model_password' => $model_password,
            'model_any' => $model_any,
            'phone_change' => $phone_change,
            'email_change' => $email_change
        ]);
    }

    public function actionMessages()
    {
        $user_id = Yii::$app->user->id;

        $model = new Messages();
        $model->scenario = Messages::SCENARIO_NEW;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->user_id_from = $user_id;
            $model->type = Messages::TYPE_NOT_READ;

            if (!$model->save()) {
                foreach ($model->getErrors() as $key => $value) {
                    Yii::$app->session->setFlash('error', $value);
                }
            } else {
                Yii::$app->session->setFlash('success', 'Сообщение успешно отправлено');
                return $this->refresh();
            }

        }

        $chats = Messages::findAllChatsWithUser($user_id);

        $chat_id = Yii::$app->request->get('chat');
        if (!$chat_id) {
            $chatsIdFind = Messages::find()->where(['user_id_to' => $user_id])->one();
            if ($chatsIdFind) {
                $chat_id = $chatsIdFind->user_id_from;
            } else {
                $chatsIdFind = Messages::find()->where(['user_id_from' => $user_id])->one();
                if($chatsIdFind){
                    $chat_id = $chatsIdFind->user_id_to;
                }
            }
        }

        $messages = Messages::messagesWithUsers($user_id, $chat_id);

        $model->text = '';

        if ($chat_id) {
            Messages::setRead($chat_id, $user_id);
        }

        return $this->render('messages', [
            'model' => $model,
            'chat_id' => $chat_id,
            'user_id' => $user_id,
            'chats' => $chats,
            'messages' => $messages
        ]);
    }

    public function actionHelp()
    {

        if (!$user = Users::findOne(Yii::$app->user->id)) {
            Yii::$app->session->setFlash('warning', 'Сообщение не отправлено.');
            return $this->refresh();
        }

        $model = new HelpForm();
        $model->scenario = HelpForm::SCENARIO_NEW;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = Users::findOne(Yii::$app->user->id);
            $label = 'Сообщение из раздела "Помощь" на сайте ' . Yii::$app->params['siteName'];
            $text = $model->text .'<br/>'. Yii::$app->params['domain'] . '/admin/users/view?id=' . $user->id;
            Yii::$app->Email->sendToHelp($label, $text, $user->email);
            Yii::$app->getSession()->setFlash('success', 'Сообщение отправлено, в ближайшее время мы отваетим на Ваш E-mail (' . $user->email . ').');
        }

        $model->text = "";
        return $this->render('help', [
            'user' => $user,
            'model' => $model
        ]);
    }

    public function actionEmailHash()
    {
        $email_hash = new Emailhash();
        $email_hash->scenario = Emailhash::SCENARIO_CHANGE_EMAIL;

        if ($email_hash->load(Yii::$app->request->get(), "") && $email_hash->validate()) {
            $model_hash = Emailhash::find()->where(['hash' => $email_hash->hash])->one();

            if(!$model_hash){
                Yii::$app->session->setFlash('danger', 'E-mail не изменен. Во время изменения произошла ошибка, пожалуйста, обратитесь к администратору.');
                return $this->redirect(['/']);
            }

            if ($model_hash->type == Emailhash::EMAIL_CHANGE) {

                $change_email = ChangeEmails::find()->where(['user_id' => $model_hash->user_id])->one();
                $user = Users::findOne($model_hash->user_id);
                $user->email = $change_email->email;
                $user->save();
                $model_hash->delete();
                if ($change_email) {
                    $change_email->delete();
                }

                foreach (ChangeEmails::find()->where(['user_id' => $model_hash->user_id])->all() as $change){
                    $change->delete();
                }

                foreach (Emailhash::find()->where(['user_id' => $model_hash->user_id])->all() as $hash){
                    $hash->delete();
                }

                Yii::$app->session->setFlash('success', 'E-mail успешно изменен.');

                return $this->redirect(['/']);
            }else if($model_hash->type == EmailHash::EMAIL_ACTIVE){
				$model_hash->delete();
				Yii::$app->session->setFlash('success', 'E-mail подтвержден.');
				return $this->redirect(['/']);
			}
        }

        Yii::$app->session->setFlash('danger', 'E-mail не изменен. Во время изменения произошла ошибка, пожалуйста, обратитесь к администратору.');
        return $this->redirect(['/']);
    }

    public function actionResetSmsCode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $error = false;
        $type = false;
        $user_id = false;
        $phoneSend = false;

        if (Yii::$app->request->post('type') == Smshash::NEW_USER) {
            $phone = Yii::$app->request->post('phone');
            $user = Users::find()->where(['phone' => $phone])->one();
            if ($user) {
                $type = Smshash::NEW_USER;
                $user_id = $user->id;
                $phoneSend = $phone;
            } else {
                $error = 'Пользователь не найден';
            }
        } elseif (Yii::$app->request->post('type') == Smshash::PASSWORD_RECOVERY) {

            $phone = Yii::$app->request->post('phone');
            $user = Users::find()->where(['phone' => $phone])->one();

            if ($user) {
                $type = Smshash::PASSWORD_RECOVERY;
                $user_id = $user->id;
                $phoneSend = $phone;
            } else {
                $error = 'Пользователь не найден';
            }

        } elseif (Yii::$app->request->post('type') == Smshash::PHONE_CHANGE) {
            $phone = Yii::$app->request->post('phone');
            $user = ChangePhones::find()->where(['phone' => $phone])->andWhere(['user_id' => Yii::$app->user->id])->one();

            if ($user) {
                $type = Smshash::PHONE_CHANGE;
                $user_id = Yii::$app->user->id;
                $phoneSend = $phone;
            } else {
                $error = 'Запрос на смену соответствующего телефона у выбранного пользователя не найден.';
            }
        }

        if ($type !== false && $user_id !== false) {
            $sms_code = Yii::$app->SMS->setHash($user_id, Smshash::PHONE_CHANGE);
            Yii::$app->SMS->send($phoneSend, 'Your code: ' . $sms_code);
        } else {
            $error = 'Ошибка отправки сообщения.';
        }

        return ['error' => $error];
    }

    public function actionResetEmailCode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $error = false;
        $type = false;
        $user_id = false;

        if (Yii::$app->request->post('type') == Emailhash::EMAIL_CHANGE) {

            $email = Yii::$app->request->post('email');
            $user = ChangeEmails::find()->where(['email' => $email])->andWhere(['user_id' => Yii::$app->user->id])->one();

            if ($user) {
                $type = Emailhash::EMAIL_CHANGE;
                $user_id = Yii::$app->user->id;
                $emailSend = $email;

                foreach (ChangeEmails::find()->where(['=', 'user_id', $user_id])->all() as $changes) {
                    $changes->delete();
                }

            } else {
                $error = 'Запрос на смену соответствующего E-mail у выбранного пользователя не найден.';
            }
        }

        if ($type !== false && $user_id !== false && $emailSend !== false) {

            $newChange = new ChangeEmails();
            $newChange->user_id = $user_id;
            $newChange->email = $emailSend;
            $newChange->save();

            $email_code = Yii::$app->Email->setHash($user_id, Emailhash::EMAIL_CHANGE);
            Yii::$app->getSession()->setFlash('success', 'Вам отправлено письмо на E-mail ' . $newChange->email . ' для подтверждения смены.');
            self::sendCheckEmailMessage($newChange->email, $email_code);
        } else {
            $error = 'Ошибка отправки сообщения';
        }

        return ['error' => $error];
    }

    public function actionResendEmailActiveCode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->post('type') == Emailhash::EMAIL_ACTIVE) {
            if ($user = Users::find()->where(['=', 'id', Yii::$app->user->id])->one()) {

                $email_code = Yii::$app->Email->setHash($user->id, Emailhash::EMAIL_ACTIVE);
                $label = 'Подтверждение E-mail адреса';

                $text = 'Для подтверждения E-mail адреса, перейдите по <a href="' . Yii::$app->params['domain'] . '/cabinet/email-hash?hash=' . $email_code . '">ссылке</a>';

                Yii::$app->Email->send($user->email, $label, $text, $type_from = false);
                Yii::$app->getSession()->setFlash('success', 'Вам отправлено письмо на E-mail ' . $user->email . ' для подтверждения E-mail.');
                return ['error' => false];
            }
        }
        return ['error' => 'Ошибка отправки E-mail'];
    }

    public static function sendCheckEmailMessage($email, $code)
    {
        $label = 'Подтверждение смены E-mail адреса на сайте';
        $text = 'Для подтверждения смены E-mail адреса, перейдите по <a href="' . Yii::$app->params['domain'] . '/cabinet/email-hash?hash=' . $code . '">ссылке</a>';
        Yii::$app->Email->send($email, $label, $text, ChangeEmails::TYPE_NO_REPLY);
    }
}
