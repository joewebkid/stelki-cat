<?php namespace app\common\actions\user;

use app\models\TempToken;
// use MuVO\Yii2\Notifications\Notification;
use yii\base\DynamicModel;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class PasswordSetAction extends UserAction
{
    public function run(string $token)
    {
        $this->controller->layout = 'form';
        $this->controller->view->title = \Yii::t('app', 'Set new password');

        $form = (new DynamicModel(['password', 'password_repeat']))
            ->addRule('password', 'required', ['message' => \Yii::t('app', "Password cannot be blank.")])
            ->addRule('password', 'string', ['min' => 6, 'message' => \Yii::t('app', "Password should contain at least 6 characters.")])
            ->addRule('password_repeat', 'required', ['message' => \Yii::t('app', "Password confirm cannot be blank.")])
            ->addRule('password_repeat', 'compare', ['compareAttribute' => 'password', 'message' => \Yii::t('app', 'Password confirm must be equal to "Password".')]);

        try {
            if (!$token = TempToken::getByValue(TempToken::TYPE_PWRESET, $token)) {
                throw new NotFoundHttpException(\Yii::t('app', 'Token not found'));
            }

            if (\Yii::$app->request->getIsPost()) {
                $form->load(\Yii::$app->request->post());
                if (!$form->validate()) {
                    throw new BadRequestHttpException(\Yii::t('app', 'Incorrect values in form'));
                } elseif (!$token->owner->setPassword($form->password)->save()) {
                    throw new ServerErrorHttpException(\Yii::t('app', "Can't change password"));
                }

                $token->delete();

                // Notification::info(\Yii::t('app', 'New password set'), 1500);

                return $this->controller->redirect([$this->controller->module->defaultRoute]);
            }
        } catch (\Throwable $e) {
            // Notification::error($e->getMessage());
        }

        return $this->controller->render('password-set', ['model' => $form]);
    }
}