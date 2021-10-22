<?php
$this->title = 'Главная';
$this->registerJsFile(
    '@web/js/burgerShow.js'
);
?>
<main>
    <div class="main-heading">
        <div class="main-heading__container _container">
            <div class="main-heading__heading-column column">			
                <h1 class="main-heading__title title">Индивидуальные ортопедические стельки</h1>
                <a class="main-heading_btn btn">Узнать подробнее</a>
            </div>
            <img src="/images/illustrations/image_1.webp" class="main-heading__ill" />

        </div>
        <div class="main-heading__image-column column">
        </div>
    </div>
    <section class="section introduction _container">
        <h2 class="section__header title">О компании</h2>
        <div class="introduction__information info-block__container info">
            <div class="info-block">
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
        <div class="mission-block">
                <strong>FUTURE STEP</strong> – наша забота <br> о качестве вашей жизни
            </div>
    </section>
    <section class="section main_content">			
        <div class="main_content__info _container">
            <h2 class="section__header main_content__header title">Преимущества наших стелек</h2>
            <div class="image_container">
                <img class="adv_ill" src="/images/illustrations/illustration.png" alt="">
            </div>
            <ul class="advantages">
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
    <section class="section _content _container" >
        <h2 class="section__header title">Наши цены</h2>
        <div class="prices info-block__container">
            <div class="prices__block info-block prices__wrap">
                <h5 class="rate_number">Тариф 1</h5>
                <p class="price">от <span>2900</span></p>
                <a class="promo__btn btn">Заказать</a>
            </div>
            <div class="prices__block info-block prices__wrap">
                <h5 class="rate_number">Тариф 2</h5>
                <p class="price">от <span>3900</span></p>
                <a class="promo__btn btn">Заказать</a>
            </div>
            <div class="prices__block info-block prices__wrap">
                <h5 class="rate_number">Тариф 3</h5>
                <p class="price">от <span>4900</span></p>
                <a class="promo__btn btn">Заказать</a>
            </div>
        </div>
    </section>
    <section class="section _content _container">
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