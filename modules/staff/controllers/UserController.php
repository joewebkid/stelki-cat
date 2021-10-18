<?php

namespace app\modules\staff\controllers;

use MuVO\Yii2\Notifications\Notification;
use app\common\actions\user\LoginAction;
use app\common\actions\user\LogoutAction;
use app\common\actions\user\PasswordChangeAction;
use app\common\actions\user\PasswordRecoveryAction;
use app\common\actions\user\PasswordSetAction;
use app\common\actions\user\ActivateAction;
use app\common\actions\user\UserLoginChange;
use yii\data\ActiveDataProvider;

use Yii;
use yii\web\Controller;
use yii\web\ServerErrorHttpException;
use app\modules\staff\models\Staff;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\DynamicModel;
use app\helpers\Notify;

class UserController extends Controller
{
    /**
     * @var string
     */
    public $defaultAction = 'sign-in';

    /**
     * @var Staff
     */
    private $user;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (Yii::$app->user->identity instanceof Staff) {
            $this->user = Yii::$app->user->identity;
            Yii::info(Yii::t('app', "We are detected investor: {login} :-)",
                ['login' => $this->user->login]), __METHOD__);
        }
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'activate' => PasswordSetAction::class,
            'sign-in' => [
                'class' => LoginAction::class,
                'viewPath' => '@app/modules/staff/views/user',
            ],
            'email-change' => UserLoginChange::class,
            'password-change' => PasswordChangeAction::class,
            'password-recovery' => PasswordRecoveryAction::class,
            'password-set' => PasswordSetAction::class,

            'sign-out' => LogoutAction::class,
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        return $this->render('list', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Staff::find()
            ])
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionBlock($id)
    {
        if (!($model = Staff::findOne($id))) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->status = 0;
        if ($model->save()) {
            return $this->redirect(['/admin/user/list']);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUnblock($id)
    {
        if (!($model = Staff::findOne($id))) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->status = 1;
        if ($model->save()) {
            return $this->redirect(['/admin/user/list']);
        }
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionCreate()
    {
        $this->view->title = Yii::t('app', "Register as new admin");

        $model = (new DynamicModel(['login']))
            ->addRule(['login'], 'required', ['message' => \Yii::t('app', "E-mail cannot be blank.")])
            ->addRule(['login'], 'email', ['message' => \Yii::t('app', "E-mail is not a valid email address.")]);

        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());
            if (!$model->validate()) {
                throw new BadRequestHttpException(Yii::t('app', 'Incorrect values in form: {err}',
                    ['err' => current($model->firstErrors)]));
            }

            $staff = new Staff(['status' => Staff::STATUS_ENABLED, 'invited_by' => $this->user->id] + $model->toArray(['login']));
            if (!$staff->validate()) {
                throw new BadRequestHttpException(Yii::t('app', 'Incorrect values in form: {err}',
                    ['err' => current($staff->firstErrors)]));
            }

            if (!$staff->save()) {
                throw new BadRequestHttpException(Yii::t('app', 'The requested page does not exist.',
                    ['err' => current($staff->firstErrors)]));
            }

            $url = $staff->resetPassword();

            Notify::add('admin_invite',
                [
                    'email_to' => $staff->login,
                    'url' => $url,
                ]);

            Notification::info(\Yii::t('app', "A confirmation of registration was sent to the indicated E-mail."), 2000);
            return $this->redirect(['user/list']);
        }

        return $this->render('create', ['model' => $model]);

    }

    public function actionSettings()
    {
        return $this->render('settings');
    }
}