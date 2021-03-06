<?php
$this->title = 'Каталог';
$this->registerJsFile('@web/js/processAnimate.js');
$this->registerJsFile('@web/js/script.js');
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js');
$this->registerJsFile('https://unpkg.com/imask');
?>
<main class="catalog catalog_daily">
    <section class="catalog__intro">
        <div class="catalog__information info-block__container info _container">
            <div class="info-block">
                <h1 class="section__header title cat-title"><?= $block1[0] ?></h1>
                <p class="text catalog__text text_emphasys"><?= $block1[1] ?></p>
            </div>
            <div class="info-block">
                <p class="text catalog__text"><?= $block2 ?></p>
            </div>
        </div>
    </section>
    <section>
        <div class="catalog_daily__text-block">
            <?= $block3 ?>
        </div>
        <div class="catalog_daily__catalog_block">
            <div class=first-column>
                <div class="catalog_block_item technology__process-block horizontal-block">
                    <div class="text-column">
                        <h3 class="title"><?= $block4[0] ?></h3>
                        <p class="text"><?= $block4[1] ?></p>
                        <button type="submit" class="btn">Заказать</button> <span class="price">от 10 900р.</span>
                    </div>
                    <div class="image_container">
                        <picture>
                            <source srcset="/images/illustrations/dailycat1.webp" type="image/webp">
                            <img src="/images/illustrations/dailycat1.png" class="tech_ill" alt="" />
                        </picture>
                    </div>
                </div>
                <div class="catalog_block_item technology__process-block horizontal-block">
                    <div class="text-column">
                        <h3 class="title"><?= $block5[0] ?></h3>
                            <p class="text"><?= $block5[1] ?></p>
                            <button type="submit" class="btn">Заказать</button> <span class="price">от 10 900р.</span>
                    </div>
                    <div class="image_container">
                        <picture>
                            <source srcset="/images/illustrations/dailycat3.webp" type="image/webp">
                            <img src="/images/illustrations/dailycat3.png" class="tech_ill" alt="" />
                        </picture>
                    </div>
                </div>
                <div class="catalog_block_item technology__process-block horizontal-block">
                    <div class="text-column">
                        <h3 class="title"><?= $block6[0] ?></h3>
                        <p class="text"><?= $block1[1] ?></p>
                        <button type="submit" class="btn">Заказать</button> <span class="price">от 10 900р.</span>
                    </div>
                    <div class="image_container">
                        <picture>
                            <source srcset="/images/illustrations/dailycat5.webp" type="image/webp">
                            <img src="/images/illustrations/dailycat5.png" class="tech_ill" alt="" />
                        </picture>
                    </div>
                </div>
            </div>
            <div class=second-column>
                <div class="catalog_block_item technology__process-block vertical-block">
                    <div class="image_container">
                        <picture>
                            <source srcset="/images/illustrations/dailycat2.webp" type="image/webp">
                            <img src="/images/illustrations/dailycat2.png" class="tech_ill" alt="" />
                        </picture>
                    </div>
                    <div class="text-column">
                        <h3 class="title"><?= $block7[0] ?></h3>
                        <p class="text"><?= $block7[1] ?></p>
                        <button type="submit" class="btn">Заказать</button> <span class="price">от 10 900р.</span>
                    </div>
                </div>
                <div class="catalog_block_item technology__process-block vertical-block">
                    <div class="text-column">
                        <div class="image_container">
                            <picture>
                                <source srcset="/images/illustrations/dailycat4.webp" type="image/webp">
                                <img src="/images/illustrations/dailycat4.png" class="tech_ill" alt="" />
                            </picture>
                        </div>
                        <h3 class="title"><?= $block8[0] ?></h3>
                        <p class="text"><?= $block8[1] ?></p>
                        <button type="submit" class="btn">Заказать</button> <span class="price">от 10 900р.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section promo_content catalog_promo _container">
        <div class="promo info-block__container">
            <div class="promo__block info-block">
                <h2 class="section__header title">
                    Оставьте заявку на бесплатное сканирoвание стоп
                </h2>
                <p class="text">с вами свяжется наш специалист и запишет на прием к врачу-ортопеду в удобное для
                    вас время</p>
            </div>
            <div class="promo__block info-block form-block">
                <?= $this->render('@app/views/site/sign_form', ['model' => $signFormModel], true) ?>
            </div>
        </div>
    </section>
</main>