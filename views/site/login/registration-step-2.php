<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use \app\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Smshash;

$this->title = 'Регистрация, шаг 2';
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
            'labelOptions' => ['class' => 'control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password_repeat')->passwordInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'code')->textInput(['autofocus' => true]) ?>

    <span id="send_sms_again" data-sms-type="<?= Smshash::NEW_USER ?>" data-phone="<?= $user->phone ?>">Отправить SMS повторно</span>

        <div class="form-group">
            <div class="">
                <?= Html::submitButton('Завершить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <?= Html::a('Изменить номер', ['site/registration'], ['class'=>'']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    </div>
</div>
