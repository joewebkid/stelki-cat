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
    <div class="chats__messages_cont">

        <?= $this->render('parts/_chatMenu', ['chats' => $chats,'chat_id'=>$chat_id]); ?>
        <br/>
        <div>

           <?php if ($chat_id) { ?>

            <div class="chat__container">
                <?php

                $lastDate = false;
                foreach ($messages as $message) {

                    $date = strtotime($message->created_at);
                    $thisDate = Date('Y/m/d', $date);

                    if ($lastDate != $thisDate) {
                        $lastDate = $thisDate;
                        ?>
                        <div class="message-block-date">
                            <div class="block__date"><?= Date('d', $date) ?> <?= Yii::$app->DateTime->monthString(Date('m', $date)) ?>
                            <?php

                            if (Date('Y', $date) !== Date('Y', time())) {
                                ?>
                                <?= Date('Y', $date) ?> года
                                <?php
                            }
                            ?></div>
                        </div>
                        <?php
                    }

                    ?>

                    <?php if ($message->user_id_from == $user_id) { ?>
                        <div class="message_block from__me">
                            <div class="message-from-me message__container_block">
                                <div class="message-body"><?= $message->text ?></div>
                                <div class="message-time"><?= Date('H:m', $date) ?></div>
                                <div class="message-status"><?= ($message->type == 1 ? '<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="check-double" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-check-double fa-w-16 fa-2x"><g class="fa-group"><path fill="currentColor" d="M166.57 282.71L44 159.21a17.87 17.87 0 0 1 .18-25.2l42.1-41.77a17.87 17.87 0 0 1 25.2.18l68.23 68.77L336.87 5.11a17.88 17.88 0 0 1 25.21.18L404 47.41a17.88 17.88 0 0 1-.18 25.21L191.78 282.89a17.88 17.88 0 0 1-25.21-.18z" class="fa-secondary"></path><path fill="currentColor" d="M504.5 172a25.86 25.86 0 0 1 0 36.42L210.1 504.46a25.48 25.48 0 0 1-36.2 0L7.5 337.1a25.84 25.84 0 0 1 0-36.41l36.2-36.41a25.48 25.48 0 0 1 36.2 0L192 377l240.1-241.46a25.5 25.5 0 0 1 36.2 0L504.5 172z" class="fa-primary"></path></g></svg>' : '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-check fa-w-16 fa-2x"><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" class=""></path></svg>'
                                ) ?></div>
                            </div>
                        </div>

                    <?php } else { ?>

                        <div class="message_block to__me">
                            <div class="message-to-me message__container_block">
                                <div class="message-body"><?= $message->text ?></div>
                                <div class="message-time"><?= Date('H:m', $date) ?></div>
                            </div>
                        </div>

                    <?php } ?>

                    <?php
                }

                ?>
            </div>

                <?php $form = ActiveForm::begin([
                    'id' => 'message-form',
                    // 'layout' => 'horizontal',
                    'fieldConfig' => [
                        // 'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'control-label'],
                    ],
                ]); ?>

                <div style="display: none">
                    <?= $form->field($model, 'user_id_to')->textInput(['autofocus' => true, 'value' => $chat_id]) ?>
                </div>
                <div class="mess_container cabinet__mess">
                    <?= $form->field($model, 'text')->textarea(['placeholder'=>'Написать сообщение'])->label('') ?>
                    <?= Html::submitButton('<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-paper-plane fa-w-16 fa-2x"><g class="fa-group"><path fill="currentColor" d="M245.53 410.5l-75 92.83c-14 17.1-42.5 7.8-42.5-15.8V358l280.26-252.77c5.5-4.9 13.3 2.6 8.6 8.3L191.72 387.87z" class="fa-secondary"></path><path fill="currentColor" d="M511.59 28l-72 432a24.07 24.07 0 0 1-33 18.2l-214.87-90.33 225.17-274.34c4.7-5.7-3.1-13.2-8.6-8.3L128 358 14.69 313.83a24 24 0 0 1-2.2-43.2L476 3.23c17.29-10 39 4.6 35.59 24.77z" class="fa-primary"></path></g></svg>', ['class' => 'btn btn-primary send_mess', 'name' => 'recovery-step-1-submit']) ?>
                </div>
                <?php ActiveForm::end(); ?>

            <?php } else { ?>
                <div>У Вас пока нету ни одного диалога</div>
            <?php } ?>

        </div>

        <div class="col-lg-offset-1" style="color:#999;">
            <!--        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>-->
            <!--        To modify the username/password, please check out the code <code>app\models\User::$users</code>.-->
        </div>
    </div>
</div>
</div>
