<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use \app\assets\LoginAsset;
use app\models\Smshash;
use app\models\Emailhash;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

// $this->title = 'Кабинет';
// $this->params['breadcrumbs'][] = $this->title;
LoginAsset::register($this);
?>
<div class="container">
<div class="site-login ">

    <?= $this->render('parts/_leftMenu'); ?>
    <div class="content profile__edit">
        <!--  -->
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'action' => ['cabinet/profile-edit?section=phone'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-6 control-label'],
            ],
        ]); ?>
        <?= $form->field($model_phone, 'phone')->textInput() ?>
        <?php if (!empty($phone_change->phone)) { ?>
            <span class="alerts">Ожидает подтверждение смены <?= $phone_change->phone ?>
                    <a href="/cabinet/clear-change-phone" id="clear_change_phone"><svg aria-hidden="true"
                                                                                       focusable="false"
                                                                                       data-prefix="fal"
                                                                                       data-icon="times-circle"
                                                                                       role="img"
                                                                                       xmlns="http://www.w3.org/2000/svg"
                                                                                       viewBox="0 0 512 512"
                                                                                       class="svg-inline--fa fa-times-circle fa-w-16 fa-2x"><path
                                    fill="currentColor"
                                    d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 464c-118.7 0-216-96.1-216-216 0-118.7 96.1-216 216-216 118.7 0 216 96.1 216 216 0 118.7-96.1 216-216 216zm94.8-285.3L281.5 256l69.3 69.3c4.7 4.7 4.7 12.3 0 17l-8.5 8.5c-4.7 4.7-12.3 4.7-17 0L256 281.5l-69.3 69.3c-4.7 4.7-12.3 4.7-17 0l-8.5-8.5c-4.7-4.7-4.7-12.3 0-17l69.3-69.3-69.3-69.3c-4.7-4.7-4.7-12.3 0-17l8.5-8.5c4.7-4.7 12.3-4.7 17 0l69.3 69.3 69.3-69.3c4.7-4.7 12.3-4.7 17 0l8.5 8.5c4.6 4.7 4.6 12.3 0 17z"
                                    class=""></path></svg></a></span>
            <br/>
            <span id="send_sms_again" data-sms-type="<?= Smshash::PHONE_CHANGE ?>"
                  data-phone="<?= $phone_change->phone ?>">Отправить SMS повторно</span>
            <?= $form->field($model_phone, 'code')->textInput() ?>
            <div class="form-group">
                <div class="col-lg-11">
                    <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 'recovery-step-1-submit']) ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="form-group">
                <div class="col-lg-11">
                    <?= Html::submitButton('Изменить номер', ['class' => 'btn btn-primary', 'name' => 'recovery-step-1-submit']) ?>
                </div>
            </div>
        <?php } ?>
        <?php ActiveForm::end(); ?>
        <!--  -->
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'action' => ['cabinet/profile-edit?section=email'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-6 control-label'],
            ],
        ]); ?>
        <?= $form->field($model_email, 'email')->textInput(['autofocus' => true]) ?>
        <?php
        if (!$user->isEmailAcitve) {
            ?>
            <span class="alerts">Ожидает подтверждение E-mail</span>
            <br/>
            <?php if (empty($email_change->email)) { ?>
                <span id="send_email_active_again" data-email-type="<?= Emailhash::EMAIL_ACTIVE ?>"
                      data-email="<?= $user->email ?>">Отправить письмо повторно</span>
                <?php
            }
        }
        ?>
        <?php if (!empty($email_change->email)) { ?>
            <span class="alerts">Ожидает подтверждение смены <?= $email_change->email ?>
                <a href="/cabinet/clear-change-email" id="clear_change_email"><svg aria-hidden="true" focusable="false"
                                                                                   data-prefix="fal"
                                                                                   data-icon="times-circle" role="img"
                                                                                   xmlns="http://www.w3.org/2000/svg"
                                                                                   viewBox="0 0 512 512"
                                                                                   class="svg-inline--fa fa-times-circle fa-w-16 fa-2x"><path
                                fill="currentColor"
                                d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 464c-118.7 0-216-96.1-216-216 0-118.7 96.1-216 216-216 118.7 0 216 96.1 216 216 0 118.7-96.1 216-216 216zm94.8-285.3L281.5 256l69.3 69.3c4.7 4.7 4.7 12.3 0 17l-8.5 8.5c-4.7 4.7-12.3 4.7-17 0L256 281.5l-69.3 69.3c-4.7 4.7-12.3 4.7-17 0l-8.5-8.5c-4.7-4.7-4.7-12.3 0-17l69.3-69.3-69.3-69.3c-4.7-4.7-4.7-12.3 0-17l8.5-8.5c4.7-4.7 12.3-4.7 17 0l69.3 69.3 69.3-69.3c4.7-4.7 12.3-4.7 17 0l8.5 8.5c4.6 4.7 4.6 12.3 0 17z"
                                class=""></path></svg></a></span>
            <br/>
            <span id="send_email_again" data-email-type="<?= Emailhash::EMAIL_CHANGE ?>"
                  data-email="<?= $email_change->email ?>">Отправить письмо повторно</span>
        <?php } ?>
        <div class="form-group">
            <div class="col-lg-11">
                <?= Html::submitButton('Изменить E-mail', ['class' => 'btn btn-primary', 'name' => 'recovery-step-1-submit']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <!--  -->
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'action' => ['cabinet/profile-edit?section=password'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-6 control-label'],
            ],
        ]); ?>
        <?= $form->field($model_password, 'password_old')->passwordInput() ?>
        <?= $form->field($model_password, 'password')->passwordInput() ?>
        <?= $form->field($model_password, 'password_repeat')->passwordInput() ?>
        <div class="form-group">
            <div class="col-lg-11">
                <?= Html::submitButton('Изменить пароль', ['class' => 'btn btn-primary', 'name' => 'recovery-step-1-submit']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <!--  -->
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'action' => ['cabinet/profile-edit?section=any'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-6 control-label'],
            ],
        ]); ?>
        <?= $form->field($model_any, 'login')->textInput() ?>
        <?= $form->field($model_any, 'email_newsletter')->checkbox([
            'template' => '{label}<div class="col-md-6 check">{input}</div><div class="col-md-6">{error}</div>'
        ]) ?>
        <?= $form->field($model_any, 'sms_newsletter')->checkbox([
            'template' => '{label}<div class="col-md-6 check">{input}</div><div class="col-md-6">{error}</div>'
        ]) ?>
        <div class="form-group">
            <div class="col-lg-11">
                <?= Html::submitButton('Изменить информацию', ['class' => 'btn btn-primary', 'name' => 'recovery-step-1-submit']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <!--  -->
    </div>
</div>
</div>
