<?php
$this->title = 'Главная';
$this->registerJsFile(
    '@web/js/burgerShow.js'
);
$this->registerJsFile(
    'https://unpkg.com/imask'
);
$this->registerJsFile(
    '@web/js/script.js'
);
?>
<main>
<div class="main-heading">
    <div class="main-heading__container _container">
        <div class="main-heading__heading-column column">
            <h1 class="main-heading__title title">Индивидуальные ортопедические стельки</h1>
            <div class="text-wrapper">
                <p class="main-heading__text">Изготавливаются на заказ с выездом на дом</p> 
                <a class="main-heading_btn btn">Узнать подробнее</a>
            </div>
        </div>
        <picture>
            <source srcset="/images/illustrations/image_1.webp" type="image/webp">
            <img src="/images/illustrations/image_1.png" class="main-heading__ill" />
        </picture>
        </div>
        <div class="main-heading__image-column column"></div>
    </div>
    <section class="section introduction _container">
        <div class="introduction__information info-block__container info">
            <div class="info-block">
                <h1 class="section__header title">О компании</h1>
                <div class="text-container">
                    <p class="text">
                        <?= $aboutCompanyLeftBlock ?>
                    </p>
                </div>
            </div>
            <div class="info-block">
                <div class="text-container">
                    <p class="text">
                        <?= $aboutCompanyRightBlock ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="mission-block"> <strong>FUTURE STEP</strong> – наша забота
            <br>о качестве вашей жизни
        </div>
    </section>
    <section class="section main_content">
        <div class="main_content__info _container">
            <h2 class="section__header main_content__header title">Преимущества наших стелек</h2>
            <div class="image-attention"></div>
            <div class="image_container">
                <picture>
                    <source srcset="/images/illustrations/illustration.webp" type="image/webp">
                    <img class="adv_ill" src="/images/illustrations/illustration.png" alt="">
                </picture>
            </div>
            <ul class="advantages _container">
                <li class="advantage">
                    <h4 class="adv_name">Облегчают</h4>
                    <p class="adv_desc">боль в пяточной области</p>
                </li>
                <li class="advantage">
                    <h4 class="adv_name">Снижают нагрузку</h4>
                    <p class="adv_desc">на суставы и стопы</p>
                </li>
                <li class="advantage">
                    <h4 class="adv_name">Улучшают</h4>
                    <p class="adv_desc">крообращение ног</p>
                </li>
                <li class="advantage">
                    <h4 class="adv_name">Предупреждают</h4>
                    <p class="adv_desc">развитие заболеваний стоп</p>
                </li>
                <li class="advantage">
                    <h4 class="adv_name">Повышают</h4>
                    <p class="adv_desc">устойчивость стопы</p>
                </li>
                <li class="advantage">
                    <h4 class="adv_name">Уменьшают</h4>
                    <p class="adv_desc">боль в области пальцев</p>
                </li>
            </ul>
        </div>
    </section>
    <div class="technology__advantegies _container">
        <div class="tecnology__advantage-block">
            <h2 class="title adv_main-title">Преиму&shyщества наших стелек</h2>
        </div>
        <div class="tecnology__advantage-block advantage-block">
            <h4 class="advantage-block__title">
                <picture>
                    <source srcset="/images/icon/adv_icon7.webp" type="image/webp">
                    <img src="/images/icon/adv_icon7.png" alt="" class="advantage-block__image">
                </picture>
                Немецкое качество
            </h4>
            <p class="advantage-block__text text">
                Геометрия стельки выполняется согласно передовым медицинским технологиям Германии на высокоточном немецком оборудовании
            </p>
        </div>
        <div class="tecnology__advantage-block advantage-block">
            <h4 class="advantage-block__title">
                <picture>
                    <source srcset="/images/icon/adv_icon9.webp" type="image/webp">
                    <img src="/images/icon/adv_icon9.png" alt="" class="advantage-block__image">
                </picture>
                Гипоаллергенность
            </h4>
            <p class="advantage-block__text text">
                При создании стелек используются только экологически чистые и гипоаллергенные материалы, произведенные в немецком городе Оберкохене
            </p>
        </div>
        <div class="tecnology__advantage-block advantage-block">
            <h4 class="advantage-block__title">
                <picture>
                    <source srcset="/images/icon/adv_icon8.webp" type="image/webp">
                    <img src="/images/icon/adv_icon8.png" alt="" class="advantage-block__image">
                </picture>
                Надежность
            </h4>
            <p class="advantage-block__text text">
                Изготовленное изделие не требует никаких изменений и коррекций – уникальный односоставный материал позволит сохранять форму изделия на весь срок службы
            </p>
        </div>
        <div class="tecnology__advantage-block advantage-block">
            <h4 class="advantage-block__title">
                <picture>
                    <source srcset="/images/icon/adv_icon10.webp" type="image/webp">
                    <img src="/images/icon/adv_icon10.png" alt="" class="advantage-block__image">
                </picture>
                Свобода выбора
            </h4>
            <p class="advantage-block__text text">
                Стельки изготавливаются для любой обуви. Ощущайте удобство всегда и везде, где бы вы не находились
            </p>
        </div>
        <div class="tecnology__advantage-block advantage-block">
            <h4 class="advantage-block__title">
                <picture>
                    <source srcset="/images/icon/adv_icon2.webp" type="image/webp">
                    <img src="/images/icon/adv_icon2.png" alt="" class="advantage-block__image">
                </picture>
                Динамические измерения
            </h4>
            <p class="advantage-block__text text">
                Размер стельки подбирается индивидуально в ходе динамического измерения стопы. Такой подход позволяет изготавливать стельки с точностью до двух микрон
            </p>
        </div>
        <div class="tecnology__advantage-block advantage-block">
            <h4 class="advantage-block__title">
                <picture>
                    <source srcset="/images/icon/adv_icon6.webp" type="image/webp">
                    <img src="/images/icon/adv_icon6.png" alt="" class="advantage-block__image">
                </picture>
                Медицинский сервис
            </h4>
            <p class="advantage-block__text text">
                Вам доступны консультации с лучшими специалистами в области ортопедии – врачами из России и Германии
            </p>
        </div>
        <div class="tecnology__advantage-block advantage-block">
            <h4 class="advantage-block__title">
                <picture>
                    <source srcset="/images/icon/adv_icon1.webp" type="image/webp">
                    <img src="/images/icon/adv_icon1.png" alt="" class="advantage-block__image">
                </picture>
                Правильные инвестиции
            </h4>
            <p class="advantage-block__text text">
                Заказывая стельки Future Step, вы инвестируете в самое важное – в свое здоровье. Правильно подобранные стельки предотвратят возможные проблемы с опорно-двигательным аппаратом и защитят ваши суставы
            </p>
        </div>
    </div>
    <section class="section promo_content _container">
        <div class="promo info-block__container">
            <div class="promo__block info-block">
                <h2 class="section__header title">Запишитесь на бесплатное сканирование</h2>
                <p class="text">стоп прямо сейчас и получите скидку</p>
                <strong class="promo__discount">-25%</strong>
            </div>
            <div class="promo__block info-block" id="sign-block">
            	<?= $this->render('sign_form', ['model' => $signFormModel], true) ?>
			</div>
        </div>
    </section>
</main>