<?php namespace app\common\actions\user;

// use MuVO\Yii2\Notifications\Notification;
use yii\base\DynamicModel;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\ServerErrorHttpException;

class PasswordChangeAction extends UserAction
{
    /**
     * @return string
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     * @throws ServerErrorHttpException
     */
    public function run()
    {
        $this->controller->layout = 'form';
        $this->controller->view->title = \Yii::t('app', "Change password");

        $form = (new DynamicModel(['password_current', 'password_new', 'password_new_repeat']))
            ->addRule('password_current', 'required', ['message' => \Yii::t('app', "Password current cannot be blank.")])
            ->addRule('password_new', 'required', ['message' => \Yii::t('app', "Password new cannot be blank.")])
            ->addRule('password_new', 'string', ['min' => 6, 'message' => \Yii::t('app', "Password should contain at least 6 characters.")])
            ->addRule('password_new_repeat', 'required', ['message' => \Yii::t('app', "Password new confirm cannot be blank.")])
            ->addRule(['password_current', 'password_new'], 'string')
            ->addRule(['password_new_repeat'], 'compare', ['compareAttribute' => 'password_new', 'message' => \Yii::t('app', 'Password new confirm must be equal to "Password New".')]);

        if (\Yii::$app->request->getIsPost()) {
            try {
                $form->load(\Yii::$app->request->post());
                if (!$form->validate()) {
                    throw new BadRequestHttpException(\Yii::t('app', 'Incorrect values in form'));
                } elseif (!\Yii::$app->user->identity->checkPassword($form->password_current)) {
                    throw new ForbiddenHttpException(\Yii::t('app', "Incorrect password"));
                } elseif (!\Yii::$app->user->identity->setPassword($form->password_new)->save()) {
                    throw new ServerErrorHttpException(\Yii::t('app', "Can't update profile: {e}",
                        ['e' => current(\Yii::$app->user->identity->firstErrors)]));
                }

                // Notification::info(\Yii::t('app', "New password set successfully"), 2000);

                return $this->controller->redirect([$this->controller->module->defaultRoute]);
            } catch (\Throwable $e) {
                // Notification::error($e->getMessage());
            }
        }

        return $this->controller->render('password-change', ['model' => $form]);
    }
}
