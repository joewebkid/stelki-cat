<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use \app\assets\LoginAsset;
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

        <?php if ($email) { ?>
            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'value' => $email]) ?>
        <?php } else { ?>
            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
        <?php } ?>

        <div id="message">
            <?= \Yii::$app->session->getFlash('error'); ?>
        </div>

        <div class="form-group">
            <div class="">
                <?= Html::submitButton('Получить код', ['class' => 'btn btn-primary', 'name' => 'recovery-step-1-submit']) ?>
                <div class="design__login__but">
                    <?= Html::a('Войти', ['site/login'], ['class' => 'btn btn-default butt__login']) ?>
                    <?= Html::a('Регистрация', ['site/registration'], ['class' => 'btn btn-default butt__login']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
