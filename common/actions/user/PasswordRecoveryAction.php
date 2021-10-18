<?php namespace app\common\actions\user;

use app\helpers\Notify;
// use MuVO\Yii2\Notifications\Notification;
use yii\base\DynamicModel;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class PasswordRecoveryAction extends UserAction
{
    /**
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function run()
    {
        $this->controller->layout = 'form';
        $this->controller->view->title = \Yii::t('app', 'Password recovery');

        $form = (new DynamicModel(['email']))
            ->addRule('email', 'required', ['message' => \Yii::t('app', "E-mail cannot be blank.")])
            ->addRule('email', 'email', ['message' => \Yii::t('app', "E-mail is not a valid email address.")]);
//            ->addRule('email', 'exist', [
//                'targetClass' => \Yii::$app->user->identityClass,
//                'targetAttribute' => 'login',
//                'message' => \Yii::t('app', 'User not registered'),
//            ]);

        if (\Yii::$app->request->getIsPost()) {
            try {
                $form->load(\Yii::$app->request->post());
                if (!$form->validate()) {
                    throw new BadRequestHttpException(current($form->firstErrors));
                } elseif (!$user = (\Yii::$app->user->identityClass)::fetchActive($form->email)) {
                    throw new NotFoundHttpException(\Yii::t('app', 'User not found'));
                } elseif (!$url = $user->resetPassword()) {
                    throw new ServerErrorHttpException(\Yii::t('app', "Can't process action"));
                }

                // Notify::add('password_recovery',
                //     [
                //         'email_to' => $user->login,
                //         'url' => $url,
                //     ]);
                // Notification::info(\Yii::t('app', 'Password reset link sent to your email'));
            } catch (\Throwable $e) {
                // Notification::error($e->getMessage());
            }
        }

        return $this->controller->render('password-recovery', ['model' => $form]);
    }
}
