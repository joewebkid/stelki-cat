<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use \app\assets\LoginAsset;
use app\models\Smshash;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
// $this->params['breadcrumbs'][] = $this->title;
LoginAsset::register($this);
?>
<div class="content pretty__input__container">
    <div class="pretty__input">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            // 'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}<div class=''>{input}</div><div class=''>{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput(['autofocus' => true]) ?>
        <!--    --><? //= $form->field($model, 'code')->textInput(['autofocus' => true]) ?>

        <div id="message">
            <?= \Yii::$app->session->getFlash('error'); ?>
        </div>


        <div class="form-group">
            <div class="">
                <!--            <span id="send_sms_again" data-sms-type="-->
                <? //= Smshash::PASSWORD_RECOVERY ?><!--" data-phone="-->
                <? //= $user->phone ?><!--">Отправить SMS повторно</span>-->
                <?= Html::submitButton('Завершить', ['class' => 'btn btn-primary', 'name' => 'recovery-step-2-submit']) ?>
                <!--            <div class="design__login__but">-->
                <!--            --><? //= Html::a('Изменить номер', ['site/password-recovery-step-1', 'phone' => $user->phone]) ?>
                <!--            </div>-->
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
