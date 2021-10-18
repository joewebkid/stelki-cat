<?php namespace app\common\actions\user;

use app\helpers\Notify;
use app\models\TempToken;
// use MuVO\Yii2\Notifications\Notification;
use yii\base\DynamicModel;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class UserLoginChange extends UserAction
{
    /**
     * @param string|null $token
     * @return string
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function run(string $token = null)
    {
        $this->controller->layout = 'form';
        $this->controller->view->title = \Yii::t('app', 'Change email');

        $form = (new DynamicModel(['email', 'password']))
            ->addRule('email', 'required', ['message' => \Yii::t('app', "E-mail cannot be blank.")])
            ->addRule('password', 'required', ['message' => \Yii::t('app', "Password current cannot be blank.")])
            ->addRule('password', 'string', ['min' => 6, 'message' => \Yii::t('app', "Password should contain at least 6 characters.")])
            ->addRule('email', 'email', ['message' => \Yii::t('app', "E-mail is not a valid email address.")])
            ->addRule('email', 'unique', [
                'targetClass' => \Yii::$app->user->identityClass,
                'targetAttribute' => 'login',
                'message' => \Yii::t('app', "This e-mail is already registered.")
            ]);

        try {
            if (!is_null($token)) {
                if (!$token = TempToken::getByValue(TempToken::TYPE_EMAILRESET, $token)) {
                    throw new NotFoundHttpException(\Yii::t('app', 'Token not found'));
                }

                $token->owner->setAttribute('login', $token->data_raw);
                if (!$token->owner->save()) {
                    throw new ServerErrorHttpException(\Yii::t('app', 'Can\'t update profile: {e}',
                        ['e' => current($token->owner->firstErrors)]));
                }

                $token->delete();

                // Notification::info(\Yii::t('app', 'New email set'), 2000);

                return $this->controller->redirect(['user/']);

            } elseif (\Yii::$app->request->getIsPost()) {
                $form->load(\Yii::$app->request->post());
                if (!$form->validate()) {
                    throw new BadRequestHttpException(\Yii::t('app', 'Incorrect values in form'));
                } elseif (!\Yii::$app->user->identity->checkPassword($form->password)) {
                    throw new ForbiddenHttpException(\Yii::t('app', 'Incorrect password: {pw}', ['pw' => $form->password]));
                }

                $url = \Yii::$app->user->identity->changeLogin($form->email);
                Notify::add('investor_change_mail',
                    [
                        'url' => $url,
                        'email_to' => $form->email
                    ]);
                // Notification::info(\Yii::t('app', 'We sent confirmation link to {0}', $form->email), 2000);

                return $this->controller->redirect(['user/']);
            }
        } catch (\Throwable $e) {
            // Notification::error($e->getMessage());
        }

        return $this->controller->render('login-change', ['model' => $form]);
    }
}
