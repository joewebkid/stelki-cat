<?
use app\models\BidForm;
$model = new BidForm();
?>
<div class="modal fade" id="dailyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <?= Yii::$app->controller->getHeaderHtml() ?>
    <div id="staticBackdrop" class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="info-block__container first-row info">
                    <div class="info-block">
                        <h1 class="section__header title modal-title">
                            Повседневные стельки
                        </h1>
                    </div>
                    <div class="info-block">
                        <p class="text catalog__text">Жизнь – это движение. Именно поэтому качество нашей жизни напрямую зависит от здоровья наших ног. Наша команда, состоящая из высококвалифицированных специалистов в области ортопедии и медицинской инженерии.</p>
                    </div>
                </div>
                <div class="info-block__container second-row info">
                    <div class="info-block">
                        <div id="carouseldailyModal" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouseldailyModal" data-bs-slide-to="0" class="active controls" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" class="controls" data-bs-target="#carouseldailyModal" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" class="controls" data-bs-target="#carouseldailyModal" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                <button type="button" class="controls" data-bs-target="#carouseldailyModal" data-bs-slide-to="3" aria-label="Slide 4" class="controls"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <picture>
                                        <source srcset="/images/illustrations/daily.webp" type="image/webp">
                                        <img src="/images/illustrations/daily.png" class="d-block w-100 h-100" alt="daily">
                                    </picture>
                                </div>
                                <div class="carousel-item">
                                    <picture>
                                        <source srcset="/images/illustrations/daily.webp" type="image/webp">
                                        <img src="/images/illustrations/daily.png" class="d-block w-100 h-100" alt="daily">
                                    </picture>
                                </div>
                                <div class="carousel-item">
                                    <picture>
                                        <source srcset="/images/illustrations/daily.webp" type="image/webp">
                                        <img src="/images/illustrations/daily.png" class="d-block w-100 h-100" alt="daily">
                                    </picture>
                                </div>
                                <div class="carousel-item">
                                    <picture>
                                        <source srcset="/images/illustrations/daily.webp" type="image/webp">
                                        <img src="/images/illustrations/daily.png" class="d-block w-100 h-100" alt="daily">
                                    </picture>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouseldailyModal" data-bs-slide="prev">	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouseldailyModal" data-bs-slide="next">	<span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="info-block form-column">
                        <div class="promo__block info-block">
                            <h3 class="title form-column-title">Оставьте заявку на замер стопы</h3>
                        </div>
                        <div class="promo__block info-block form-block">
                            <?= $this->render('sign_form', ['model' => $model], true) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="diabetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <?= Yii::$app->controller->getHeaderHtml() ?>
    <div id="staticBackdrop" class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="info-block__container first-row info">
                    <div class="info-block">
                        <h1 class="section__header title modal-title">
                            Стельки для диабетиков
                        </h1>
                    </div>
                    <div class="info-block">
                        <p class="text catalog__text">Жизнь – это движение. Именно поэтому качество нашей жизни напрямую зависит от здоровья наших ног. Наша команда, состоящая из высококвалифицированных специалистов в области ортопедии и медицинской инженерии.</p>
                    </div>
                </div>
                <div class="info-block__container second-row info">
                    <div class="info-block">
                        <div id="carouseldiabetModal" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouseldiabetModal" data-bs-slide-to="0" class="active controls" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" class="controls" data-bs-target="#carouseldiabetModal" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" class="controls" data-bs-target="#carouseldiabetModal" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                <button type="button" class="controls" data-bs-target="#carouseldiabetModal" data-bs-slide-to="3" aria-label="Slide 4" class="controls"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <picture>
                                        <source srcset="/images/illustrations/diabet.webp" type="image/webp">
                                        <img src="/images/illustrations/diabet.png" class="d-block w-100 h-100" alt="diabet">
                                    </picture>
                                </div>
                                <div class="carousel-item">
                                    <picture>
                                        <source srcset="/images/illustrations/diabet.webp" type="image/webp">
                                        <img src="/images/illustrations/diabet.png" class="d-block w-100 h-100" alt="diabet">
                                    </picture>
                                </div>
                                <div class="carousel-item">
                                    <picture>
                                        <source srcset="/images/illustrations/diabet.webp" type="image/webp">
                                        <img src="/images/illustrations/diabet.png" class="d-block w-100 h-100" alt="diabet">
                                    </picture>
                                </div>
                                <div class="carousel-item">
                                    <picture>
                                        <source srcset="/images/illustrations/diabet.webp" type="image/webp">
                                        <img src="/images/illustrations/diabet.png" class="d-block w-100 h-100" alt="diabet">
                                    </picture>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouseldiabetModal" data-bs-slide="prev">	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouseldiabetModal" data-bs-slide="next">	<span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="info-block form-column">
                        <div class="promo__block info-block">
                            <h3 class="title form-column-title">Оставьте заявку на замер стопы</h3>
                        </div>
                        <div class="promo__block info-block form-block">
                            <?= $this->render('sign_form', ['model' => $model], true) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <?= Yii::$app->controller->getHeaderHtml() ?>
    <div id="staticBackdrop" class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="info-block__container first-row info">
                    <div class="info-block">
                        <h1 class="section__header title modal-title">
                            Спортивные стельки
                        </h1>
                    </div>
                    <div class="info-block">
                        <p class="text catalog__text">Жизнь – это движение. Именно поэтому качество нашей жизни напрямую зависит от здоровья наших ног. Наша команда, состоящая из высококвалифицированных специалистов в области ортопедии и медицинской инженерии.</p>
                    </div>
                </div>
                <div class="info-block__container second-row info">
                    <div class="info-block">
                        <div id="carouselsportModal" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselsportModal" data-bs-slide-to="0" class="active controls" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" class="controls" data-bs-target="#carouselsportModal" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" class="controls" data-bs-target="#carouselsportModal" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                <button type="button" class="controls" data-bs-target="#carouselsportModal" data-bs-slide-to="3" aria-label="Slide 4" class="controls"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <picture>
                                        <source srcset="/images/illustrations/sport.webp" type="image/webp">
                                        <img src="/images/illustrations/sport.png" class="d-block w-100 h-100" alt="sport">
                                    </picture>
                                </div>
                                <div class="carousel-item">
                                    <picture>
                                        <source srcset="/images/illustrations/sport.webp" type="image/webp">
                                        <img src="/images/illustrations/sport.png" class="d-block w-100 h-100" alt="sport">
                                    </picture>
                                </div>
                                <div class="carousel-item">
                                    <picture>
                                        <source srcset="/images/illustrations/sport.webp" type="image/webp">
                                        <img src="/images/illustrations/sport.png" class="d-block w-100 h-100" alt="sport">
                                    </picture>
                                </div>
                                <div class="carousel-item">
                                    <picture>
                                        <source srcset="/images/illustrations/sport.webp" type="image/webp">
                                        <img src="/images/illustrations/sport.png" class="d-block w-100 h-100" alt="sport">
                                    </picture>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselsportModal" data-bs-slide="prev">	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselsportModal" data-bs-slide="next">	<span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="info-block form-column">
                        <div class="promo__block info-block">
                            <h3 class="title form-column-title">Оставьте заявку на замер стопы</h3>
                        </div>
                        <div class="promo__block info-block form-block">
                            <?= $this->render('sign_form', ['model' => $model], true) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>