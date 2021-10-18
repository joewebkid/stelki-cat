<?php namespace app\common\actions\user;

// use MuVO\Yii2\Notifications\Notification;
use yii\base\DynamicModel;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\ServerErrorHttpException;

class SetPasswordAction extends UserAction
{
    public function run()
    {
        $form = (new DynamicModel(['password_current', 'password_new', 'password_new_repeat']))
            ->addRule('password_current', 'required', ['message' => \Yii::t('app', "Password current cannot be blank.")])
            ->addRule('password_new', 'required', ['message' => \Yii::t('app', "Password new cannot be blank.")])
            ->addRule('password_new_repeat', 'required', ['message' => \Yii::t('app', "Password new confirm cannot be blank.")])
            ->addRule(['password_current', 'password_new'], 'string')
            ->addRule(['password_new_repeat'], 'compare', ['compareAttribute' => 'password_new', 'message' => \Yii::t('app', 'Password confirm must be equal to "Password".')]);

        try {
            if (\Yii::$app->request->getIsPost()) {
                $form->load(\Yii::$app->request->post());
                if (!$form->validate()) {
                    throw new BadRequestHttpException(\Yii::t('app', 'Incorrect values in form'));
                } elseif (!$this->identity->checkPassword($form->password_current)) {
                    throw new ForbiddenHttpException("Incorrect password");
                } elseif (!$this->identity->setPassword($form->password_new)->save()) {
                    throw new ServerErrorHttpException(\Yii::t('app', "Can't update profile"));
                }

                // Notification::info(\Yii::t('app', "New password set successfully"), 1500);

                return $this->controller->redirect([$this->controller->module->defaultRoute]);
            }
        } catch (\Throwable $e) {
            // Notification::error($e->getMessage());
        }

        return $this->controller->render('password-change', ['model' => $form]);
    }
}
