<?php
\app\assets\ObjectAsset::register($this);
use yii\bootstrap\ActiveForm;
use app\models\Messages;
use yii\helpers\Html;

$feedbackModel = new Messages();
$feedbackModel->scenario = Messages::SCENARIO_NEW;
$this->title = Yii::t('app', "Купить объект ".$model->typeName." ".$model->address." Объявление №".$model->id." – Машиноместо");

$favoriteClass = '';
if ( ($favorite = \Yii::$app->request->cookies['favorite']) != null ) {

    $favorite = json_decode($favorite,true);
    if ( ($elem = array_search($model->id, $favorite))!==false ) {
        $favoriteClass = 'liked';
        $script = <<< JS
        $('.to-search-mobile .like').addClass("liked")
JS;
        $this->registerJs($script, yii\web\View::POS_READY);
    }
}

?>

<div class="container">
    <div class="item__container <?= $favoriteClass ?>" data-id="<?= $model->id ?>" data-key="<?= $model->id ?>" data-name="<?= $model->name ?>" data-rooms-quantity="<?= $model->district ?>">
        <div class="item__top">
            <div class="item__foto">
        <div class="last-apartments__card-like"><span>Добавить в избранное</span></div>


                <div class="swiper-container gallery-top">
                    <div id="sync1" class="owl-carousel owl-theme">
                    <?= $model->photosHtml ?>
                    </div>
                    <div class="rightNav">
                        <div class="swiper-button-next swiper-button-white">
                            <?= $this->render('svg/_right.svg') ?>
                        </div>
                    </div>
                    <div class="leftNav">
                        <div class="swiper-button-prev swiper-button-white">
                            <?= $this->render('svg/_left.svg') ?>
                        </div>
                    </div>
                </div>

                <div class="swiper-container gallery-thumbs">

                    <div class="swiper-wrapper">
                        <div id="sync2" class="owl-carousel owl-theme">
                            <?= $model->photosHtml ?>
                        </div>
                    </div>

                </div>


            </div>
            <div class="item__map">
                <div id="object-map" class="object-map" data-lat="<?= $model->coord_lat ?>" data-lng="<?= $model->coord_len ?>"></div>
                <button class="btn-show-map">
                    <svg class="shows" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="expand-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-expand-alt fa-w-14 fa-2x"><path fill="currentColor" d="M212.686 315.314L120 408l32.922 31.029c15.12 15.12 4.412 40.971-16.97 40.971h-112C10.697 480 0 469.255 0 456V344c0-21.382 25.803-32.09 40.922-16.971L72 360l92.686-92.686c6.248-6.248 16.379-6.248 22.627 0l25.373 25.373c6.249 6.248 6.249 16.378 0 22.627zm22.628-118.628L328 104l-32.922-31.029C279.958 57.851 290.666 32 312.048 32h112C437.303 32 448 42.745 448 56v112c0 21.382-25.803 32.09-40.922 16.971L376 152l-92.686 92.686c-6.248 6.248-16.379 6.248-22.627 0l-25.373-25.373c-6.249-6.248-6.249-16.378 0-22.627z" class=""></path></svg>
                    <svg class="hides" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z" class=""></path></svg>
                </button>
            </div>
        </div>
        
        <div class="section item__middle">
            <div class="item__main">
                <div class="sign__up__h sign__up__h__mobile"><?= number_format($model->price,0,',',' ') ?> <span class="rub">&#8381;</span></div>
                <?= $this->render('_object_info.php',['model'=>$model])?>
            </div>
            <div class="item__sub">
                <div class="sign__up__form">
                    <div id="booking" class="booking__form" name="registration__form" action="/booking/not-auth" method="get">
                        <input type="hidden" name="id" value="41">  <div class="sign__up__h"><?= number_format($model->price,0,',',' ') ?> <span class="rub">&#8381;</span></div>

                        <?php if (Yii::$app->user->isGuest): ?>
                            <div class="sign__up__container">
                                Текст описания для действия
                            </div>
                           
                            <hr>
                            <button type="submit" class="btn blog__btn-show-more" onclick="$(this).hide();$('.callPhone').show();">Показать телефон</button>
                            <div class="callPhone"><?=$model->user->phone?></div>
                        <?php elseif(!Yii::$app->user->identity->isOwner($model->id)): ?>
                            <div class="sign__up__container">
                                Текст описания для действия
                            </div>
                           
                            <hr>
                            <button type="submit" class="btn blog__btn-show-more" onclick="$(this).hide();$('.callPhone').show();">Показать телефон</button>
                            <div class="callPhone"><?=$model->user->phone?></div>
                            <button type="submit" class="btn blog__btn-show-more btn__show_chat" onclick="$(this).hide();$('.mess_container').show();$('.mess_container textarea').focus();">Начать чат</button>
                            <div class="chat__form">

                                <?php yii\widgets\Pjax::begin(['id' => 'notes']) ?>
                                 <?php $form = ActiveForm::begin([
                                    'id' => 'message-form',
                                    'action' => ['cabinet/messages'],
                                    // 'layout' => 'horizontal',
                                    'fieldConfig' => [
                                        // 'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                        'labelOptions' => ['class' => 'control-label'],
                                    ],
                                ]); ?>

                                <div style="display: none">
                                    <?= $form->field($feedbackModel, 'user_id_to')->textInput(['autofocus' => true, 'value' => $model->user_id]) ?>
                                </div>

                                <div class="mess_container">
                                    <div class="mobile_container">
                                        <?= $form->field($feedbackModel, 'text')->textarea(['placeholder'=>'Написать сообщение'])->label('') ?>
                                        <?= Html::submitButton('<svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-paper-plane fa-w-16 fa-2x"><g class="fa-group"><path fill="currentColor" d="M245.53 410.5l-75 92.83c-14 17.1-42.5 7.8-42.5-15.8V358l280.26-252.77c5.5-4.9 13.3 2.6 8.6 8.3L191.72 387.87z" class="fa-secondary"></path><path fill="currentColor" d="M511.59 28l-72 432a24.07 24.07 0 0 1-33 18.2l-214.87-90.33 225.17-274.34c4.7-5.7-3.1-13.2-8.6-8.3L128 358 14.69 313.83a24 24 0 0 1-2.2-43.2L476 3.23c17.29-10 39 4.6 35.59 24.77z" class="fa-primary"></path></g></svg>', ['class' => 'btn btn-primary send_mess', 'name' => 'recovery-step-1-submit']) ?>
                                    </div>

                                    <button type="submit" class="btn blog__btn-show-more hide__chat" onclick="$('.mess_container').hide();$('.btn__show_chat').show();">Скрыть чат</button>
                                </div>

                                <?php ActiveForm::end(); ?>
                                <?php yii\widgets\Pjax::end() ?>
                            </div>
                        <?php else: ?>
                            <a type="submit" class="btn blog__btn-show-more btn-primary" href="/object/update/<?=$model->id?>">Редактировать</a>
                        <?php endif ?>
                    </div> 
                </div>
            </div>
        </div>

   </div>
</div>