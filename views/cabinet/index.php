<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use \app\assets\LoginAsset;
use app\models\Emailhash;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;

// $this->title = 'Кабинет';
// $this->params['breadcrumbs'][] = $this->title;
LoginAsset::register($this);
?>
<div class="container">
<div class="site-login ">

    <?= $this->render('parts/_leftMenu'); ?>
    <div class="user__container content">
        <div class="user__info">
            <div class="content-box__heading">Данные аккаунта</div>
            <div><label>Имя:</label> <?= $user->login ?></div>
            <div>
                <label>Телефон:</label> <?= $user->phone ? $user->phone : Html::a('указать', ['cabinet/profile-edit']) ?>
            </div>
            <div><label>Email:</label> <?= $user->email ? $user->email : Html::a('указать', ['cabinet/profile-edit']) ?>

                <?php

                if (!$user->isEmailAcitve) {
                    ?>
                    <br/>
                    <span class="alerts">Ожидает подтверждение E-mail</span>
                    <br/>
                    <span id="send_email_active_again" data-email-type="<?= Emailhash::EMAIL_ACTIVE ?>"
                          data-email="<?= $user->email ?>">Отправить письмо повторно</span>
                    <?php
                }
                ?>

            </div>
            <div><label>Получать новости на E-mail:</label> <?= $user->email_newsletter ? 'Да' : 'Нет' ?></div>
            <div><label>Получать новости по SMS:</label> <?= $user->sms_newsletter ? 'Да' : 'Нет' ?></div>
            <br/>
            <?= Html::a('Изменить', ['cabinet/profile-edit']) ?>
        </div>
        <div class="my__objects">
            <div class="content-box__heading">Мои объявления</div>
            <?= ListView::widget([
                'dataProvider' => $objectsProvider,
                'itemView' => '../layouts/_apartment-card',
                'options' => [
                    'tag' => 'div',
                    'class' => 'last-apartments__cards__cabinet',
                    'id' => 'last-apartments__cards'
                ],

                'emptyText' => 'У Вас пока нет добавленных объектов <br>
                <a class="btn btn-primary" href="/object/add">Добавить объект</a>
                 <style>
                    .last-apartments__wrapper {
                        min-height: 600px;
                    }
                 </style>',
                'itemOptions' => [
                    'tag' => false
                ],
                'layout' => "{items}{pager}",
                // 'viewParams' => [
                //     'asset' => $asset,
                // ],
                'pager' => [
                    'maxButtonCount' => 4,
                ]
            ]); ?>
        </div>
    </div>
</div>
</div>
