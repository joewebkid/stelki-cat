<?php 
namespace app\common\actions\user;

use yii\base\Action;

class LogoutAction extends Action
{
    /**
     * @return \yii\web\Response
     */
    public function run()
    {
        if (!\Yii::$app->user->getIsGuest()) {
            \Yii::$app->user->logout();
        }

//        return $this->controller->redirect(\Yii::$app->user->getReturnUrl(\Yii::$app->request->getReferrer()));

        return $this->controller->redirect(['/']);
    }
}
