<?php
$this->title = 'Каталог';
$this->registerJsFile('@web/js/processAnimate.js');
$this->registerJsFile('@web/js/script.js');
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js');
$this->registerJsFile('https://unpkg.com/imask');
?>
<main class=" catalog">
    <section class="catalog__intro">
        <section class="_container catalog__sections">
        <div class="catalog__information info-block__container info">
            <div class="info-block">
                <h2 class="title cat-title">Здоровье и комфорт в каждом шаге!</h2>
                <p class="text catalog__text">В зависимости от рецепта и клинической картины наши стельки адаптируются к вашим потребностям.</p>
                <a href="daily_insole.html">
                    <div class="image_container daily_container">
                        <picture>
                            <source srcset="/images/illustrations/daily_example.webp" type="image/webp">
                            <img src="/images/illustrations/daily_example.png" class="cat_ill" alt="" />
                        </picture>
                    </div>
                    <h4 class="catalog-heading">
                        Повседневные стельки
                        <svg
                            width="88"
                            height="24"
                            viewBox="0 0 88 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="arrow-pict"
                        >
                            <path
                                d="M87.0607 13.0607C87.6464 12.4749 87.6464 11.5251 87.0607 10.9393L77.5147 1.39341C76.9289 0.807618 75.9792 0.807618 75.3934 1.3934C74.8076 1.97919 74.8076 2.92894 75.3934 3.51473L83.8787 12L75.3934 20.4853C74.8076 21.0711 74.8076 22.0208 75.3934 22.6066C75.9792 23.1924 76.9289 23.1924 77.5147 22.6066L87.0607 13.0607ZM-1.31134e-07 13.5L86 13.5L86 10.5L1.31134e-07 10.5L-1.31134e-07 13.5Z"
                            />
                        </svg>
                    </h4>
                </a>
                <a href="children_insole.html">
                    <div class="image_container">
                        <picture>
                            <source srcset="/images/illustrations/babies_foot.webp" type="image/webp">
                            <img src="/images/illustrations/babies_foot.png" class="cat_ill" alt="" />
                        </picture>
                    </div>
                    <h4 class="catalog-heading">
                        Детские стельки
                        <svg
                            width="88"
                            height="24"
                            viewBox="0 0 88 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="arrow-pict"
                        >
                            <path
                                d="M87.0607 13.0607C87.6464 12.4749 87.6464 11.5251 87.0607 10.9393L77.5147 1.39341C76.9289 0.807618 75.9792 0.807618 75.3934 1.3934C74.8076 1.97919 74.8076 2.92894 75.3934 3.51473L83.8787 12L75.3934 20.4853C74.8076 21.0711 74.8076 22.0208 75.3934 22.6066C75.9792 23.1924 76.9289 23.1924 77.5147 22.6066L87.0607 13.0607ZM-1.31134e-07 13.5L86 13.5L86 10.5L1.31134e-07 10.5L-1.31134e-07 13.5Z"
                            />
                        </svg>
                    </h4>
                </a>
            </div>
            <div class="info-block">
                <a href="sport_insole.html">
                    <div class="image_container sport_container">
                        <picture>
                            <source srcset="/images/illustrations/sport_example.webp" type="image/webp">
                            <img src="/images/illustrations/sport_example.png" class="cat-ill sport-ill" alt="" />
                        </picture>
                    </div>
                    <h4 class="catalog-heading">
                        Спортивные стельки
                        <svg
                            width="88"
                            height="24"
                            viewBox="0 0 88 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="arrow-pict"
                        >
                            <path
                                d="M87.0607 13.0607C87.6464 12.4749 87.6464 11.5251 87.0607 10.9393L77.5147 1.39341C76.9289 0.807618 75.9792 0.807618 75.3934 1.3934C74.8076 1.97919 74.8076 2.92894 75.3934 3.51473L83.8787 12L75.3934 20.4853C74.8076 21.0711 74.8076 22.0208 75.3934 22.6066C75.9792 23.1924 76.9289 23.1924 77.5147 22.6066L87.0607 13.0607ZM-1.31134e-07 13.5L86 13.5L86 10.5L1.31134e-07 10.5L-1.31134e-07 13.5Z"
                            />
                        </svg>
                    </h4>
                </a>
                <a href="diabetics_insole.html">
                    <div class="image_container">
                        <picture>
                            <source srcset="/images/illustrations/diabetics_insole.webp" type="image/webp">
                            <img src="/images/illustrations/diabetics_insole.png" class="cat_ill" alt="" />
                        </picture>
                    </div>
                    <h4 class="catalog-heading">
                        Диабетические стельки
                        <svg
                            width="88"
                            height="24"
                            viewBox="0 0 88 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="arrow-pict"
                        >
                            <path
                                d="M87.0607 13.0607C87.6464 12.4749 87.6464 11.5251 87.0607 10.9393L77.5147 1.39341C76.9289 0.807618 75.9792 0.807618 75.3934 1.3934C74.8076 1.97919 74.8076 2.92894 75.3934 3.51473L83.8787 12L75.3934 20.4853C74.8076 21.0711 74.8076 22.0208 75.3934 22.6066C75.9792 23.1924 76.9289 23.1924 77.5147 22.6066L87.0607 13.0607ZM-1.31134e-07 13.5L86 13.5L86 10.5L1.31134e-07 10.5L-1.31134e-07 13.5Z"
                            />
                        </svg>
                    </h4>
                </a>
            </div>
        </section>
    </section>
</main>
<?//= $this->render('catalog_modals', []) ?>