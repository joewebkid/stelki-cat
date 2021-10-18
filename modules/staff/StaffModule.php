<?php

namespace app\modules\staff;

use app\common\behaviors\Language;
use app\modules\staff\models\Staff;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\User;

class StaffModule extends Module
{
    public $defaultRoute = '/admin/index';
    public $layout = 'default';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setBasePath(__DIR__);

        if (!\Yii::$app->request->getIsConsoleRequest()) {
            Yii::$app->set('user', [
                'class' => User::class,
                'identityClass' => Staff::class,
                'identityCookie' => ['name' => '_adm', 'httpOnly' => true],
                'idParam' => '__adm_id',
                'loginUrl' => ['admin/user/sign-in'],
                'enableAutoLogin' => true,
            ]);

            // // Подключаем темы
            // Yii::$app->set('view', [
            //     'class' => yii\web\View::class,
            //     'theme' => [
            //         'basePath' => '@app/themes/app/staff',
            //         'pathMap' => [
            //             '@app/modules/staff/views' => '@app/themes/app/views/staff',
            //             '@app/modules/staff/views/layouts' => '@app/themes/app/layouts/staff',
            //         ],
            //     ],
            // ]);


            $this->attachBehavior('access', [
                'class' => AccessControl::className(),
                'except' => [
                    'user/sign-in',
                    'user/sign-out',
                    'user/password-recovery',
                    'user/password-set',
                    'user/activate',
                    'metro/get-by-name',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]);
        }
    }
}
