<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use \app\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
// $this->params['breadcrumbs'][] = $this->title;
LoginAsset::register($this);
?>
<div class="container">
<div class="content pretty__input__container">
    <div class="pretty__input">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            // 'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"\">{input}</div>\n<div class=\"\">{error}</div>",
                'labelOptions' => ['class' => 'control-label'],
            ],
        ]); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="margin__login">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => '{label}<div class=" check">{input}</div><div class="">{error}</div>'
                ]) ?>
            </div>

            <div class="form-group">
                <div class="">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    <div class="design__login__but"> 
                        <?= Html::a('Регистрация', ['site/registration'], ['class' => 'btn btn-default butt__login']) ?>
                        <?= Html::a('Восстановить пароль', ['site/password-recovery-step-1'], ['class' => 'btn btn-default butt__login']) ?>                    
                    </div>
                </div>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>
