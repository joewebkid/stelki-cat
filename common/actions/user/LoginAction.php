<?php 
namespace app\common\actions\user;

use yii\base\DynamicModel;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use app\modules\investor\models\Wallet;

class LoginAction extends UserAction
{
    /**
     * @var string
     */
    public $identityClass;

    /**
     * @var Notification[]
     */
    public $successNotifications = [];

    /**
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     */
    public function run()
    {
        $this->controller->layout = 'form';
        $this->controller->view->title = \Yii::t('app', 'Sign in');

        $oldLang = \Yii::$app->session->get('language');

        $model = (new DynamicModel(['email', 'password', 'rememberMe']))
            ->addRule('email', 'required', ['message' => \Yii::t('app', "E-mail cannot be blank.")])
            ->addRule('password', 'required', ['message' => \Yii::t('app', "Password cannot be blank.")])
            ->addRule('password', 'string', ['min' => 6, 'message' => \Yii::t('app', "Password should contain at least 6 characters.")])
            ->addRule('email', 'email', ['message' => \Yii::t('app', "E-mail is not a valid email address.")])
            ->addRule('password', 'string')
            ->addRule('rememberMe', 'boolean');

        if (!\Yii::$app->user->isGuest) {
            return $this->controller->redirect($this->controller->module->defaultRoute);
        } elseif (\Yii::$app->request->getIsPost()) {
            try {
                if (\Yii::$app->has('recaptcha') && !\Yii::$app->recaptcha->verify(\Yii::$app->request)) {
                    throw new BadRequestHttpException(\Yii::t('app', 'Invalid captcha'));
                }

                $model->load(\Yii::$app->request->post());

                if (!$model->validate()) {
                    throw new BadRequestHttpException(\Yii::t('app', 'Incorrect values in form: {e}',
                        ['e' => current($model->firstErrors)]));
                }

                if (!$this->identity = (\Yii::$app->user->identityClass)::auth($model->email, $model->password)) {
                    throw new ForbiddenHttpException(\Yii::t('app', 'Invalid login or password'));
                }

//                \Yii::$app->session->remove('language');
                \Yii::$app->user->login($this->identity, $model->rememberMe ? 3600 * 24 * 30 : 60 * 15);

                if (\Yii::$app->user->identityCookie['name'] == '_investor') {
                    if (!Wallet::findOne(['investor_id' => \Yii::$app->user->id, 'type' => Wallet::TYPE_XEM])) {
                        \Yii::$app->session['emptyNem'] = true;
                    } else {
                        \Yii::$app->session['emptyNem'] = false;
                    }
                }

                // Notification::info(\Yii::t('app', "Welcome back!"), 1500);

                \Yii::$app->session->set('language', $oldLang);

                return $this->controller->redirect(\Yii::$app->user->getReturnUrl());
            } catch (\Throwable $e) {
                 \Yii::$app->getSession()->setFlash('error', $e->getMessage());
            }
        }

        return $this->controller->render('login', ['model' => $model]);
    }
}
