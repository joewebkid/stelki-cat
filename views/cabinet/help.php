<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use \app\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

// $this->title = 'Мои сообщения';
// $this->params['breadcrumbs'][] = $this->title;
LoginAsset::register($this);
?>
<div class="container">
<div class="site-login ">

    <?= $this->render('parts/_leftMenu'); ?>

    <div class="help-messages">
        <br/>
        Вы можете написать на почту <a href="mailto:mashino-mesta.ru">help@mashino-mesta.ru</a>.
        <br/>
        Либо написать сообщение здесь.

        <?php $form = ActiveForm::begin([
            'id' => 'message-form',
            // 'layout' => 'horizontal',
            'fieldConfig' => [
                // 'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'control-label'],
            ],
        ]); ?>
        <div class="mess_container cabinet__mess">
            <?= $form->field($model, 'text')->textarea(['placeholder'=>'Написать сообщение'])->label('') ?>
            <?= Html::submitButton('<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-paper-plane fa-w-16 fa-2x"><g class="fa-group"><path fill="currentColor" d="M245.53 410.5l-75 92.83c-14 17.1-42.5 7.8-42.5-15.8V358l280.26-252.77c5.5-4.9 13.3 2.6 8.6 8.3L191.72 387.87z" class="fa-secondary"></path><path fill="currentColor" d="M511.59 28l-72 432a24.07 24.07 0 0 1-33 18.2l-214.87-90.33 225.17-274.34c4.7-5.7-3.1-13.2-8.6-8.3L128 358 14.69 313.83a24 24 0 0 1-2.2-43.2L476 3.23c17.29-10 39 4.6 35.59 24.77z" class="fa-primary"></path></g></svg>', ['class' => 'btn btn-primary send_mess', 'name' => 'recovery-step-1-submit']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
</div>
