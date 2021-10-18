<?php namespace app\common\actions\user;

// use MuVO\Yii2\Notifications\Notification;
use yii\web\ServerErrorHttpException;

class ActivateAction extends UserAction
{
    public function run(string $token)
    {
        try {
            $this->identity = (\Yii::$app->user->identityClass)::decode($token);

            if (!$this->identity->save()) {
                throw new ServerErrorHttpException(\Yii::t('app', 'Can\'t save user: {e}',
                    ['e' => current($this->identity->firstErrors)]));
            }

            \Yii::$app->user->login($this->identity);
            // Notification::info(\Yii::t('app', 'Welcome aboard!'), 1500);

            try {
                if (!$address = \Yii::$app->foundation->createBtcAddress(Yii::$app->user->identity)) {
                    // Notification::warn(\Yii::t('app', "Can't generate BTC-address: {0}",
                    //     'unknown error'));
                }
            } catch (\Throwable $e) {
                // Notification::error(\Yii::t('app', "Can't generate BTC-address: {0}",
                //     $e->getMessage()));
            }

            return $this->controller->redirect([$this->controller->module->defaultRoute]);
        } catch (\Throwable $e) {
            // Notification::error($e->getMessage());
            // \Yii::error($e->getTrace(), __METHOD__);
        }

        return $this->controller->renderContent(\Yii::t('app', 'Can\'t activate'));
    }
}
