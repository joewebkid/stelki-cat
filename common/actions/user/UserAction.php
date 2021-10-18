<?php namespace app\common\actions\user;

use app\common\models\AbstractUser;
use yii\base\Action;

abstract class UserAction extends Action
{
    /**
     * @var string
     */
    public $viewPath = '@app/common/views/user';

    /**
     * @var AbstractUser
     */
    public $identity;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->controller->setViewPath($this->viewPath);
    }
}
