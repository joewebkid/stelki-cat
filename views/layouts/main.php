<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\models\Users;
use app\widgets\Alert;
use app\models\Filter;
use app\models\StaticPages;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\base\View;

AppAsset::register($this);

$menu = [['label' => 'Избранное', 'url' => ['/catalog/favorites']],
    ['label' => 'Добавить объект', 'url' => ['/site/add-object']]];


if (Yii::$app->user->isGuest) {
    $menu[] = ['label' => 'Войти', 'url' => ['/site/login']];

} else {

    $label = Yii::$app->user->identity->login ?? Yii::$app->user->identity->phone;
    if ($number = Users::findOne(Yii::$app->user->id)->countNewMessages) {
        $label .= '<span class="new-messages-icon">' . $number . '</span>';
    }

    // $menu[] = ['label' => 'Личный кабинет', 'url' => ['/cabinet?per-page=3']];
    $menu[] = ['label' => $label, 'url' => ['/cabinet']];
    // $menu[] = Yii::$app->user->isGuest ? (
    //         ''
    //         ) : (
    //             '<li>'
    //             . Html::beginForm(['/site/logout'], 'post')
    //             . Html::submitButton(
    //                 'Выйти',
    //                 ['class' => 'btn btn-link logout']
    //             )
    //             . Html::endForm()
    //             . '</li>'
    //     );
}

$headMenu = StaticPages::headMenu();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="458179b629199c5b" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<?= Alert::widget(); ?>
<div class="wrap">
    <div class="containerHrefs">
        <div class="container">
            <div class="helpMenu">
                <?php foreach ($headMenu as $listK => $listB) { ?>
                    <a href="<?= $listK ?>" class="helpHref"><?= $listB ?></a>
                    <!--                <a href="#1" class="helpHref">Как выбрать объект</a>-->
                    <!--                <a href="#1" class="helpHref">Оформление документов</a>-->
                    <!--                <a href="#1" class="helpHref">Гарантии сервиса</a>-->
                    <!--                <a href="#1" class="helpHref">Помощь</a>-->
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    NavBar::begin([
        'brandLabel' => Html::img("@web/images/logo.png") . " <div class='brandLabel'>Машиноместо</div>",
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-static-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menu,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="main__container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="gridFooter">
            <div>
                <h4>У метро</h4>
                <?= Filter::getMetros() ?>
                <!-- <a href="#1">Автово</a>            
                <a href="#1">Адмиралтейская</a>
                <a href="#1">Академическая</a>
                <a href="#1">Балтийская</a>
                <a href="#1">Беговая</a>
                <a href="#1">Бухарестская</a> -->
            </div>
            <div>
                <h4>В РАЙОНЕ</h4>
                <?= Filter::getDictricts() ?>
                <!-- <a href="#1">Калининский</a>
                <a href="#1">Адмиралтейский</a>            
                <a href="#1">Бокситогорский</a>
                <a href="#1">Василеостровский</a>
                <a href="#1">Волосовский</a>
                <a href="#1">Волховский</a> -->
                <!-- <a href="#1">Всеволожский</a> -->
            </div>
            <div>
                <h4>По ЖК</h4>
                <?= Filter::getResidentialСomplex() ?>
                <!-- <a href="#1">Чистое небо</a>            
                <a href="#1">Новая охта</a>
                <a href="#1">Солнечный город</a>
                <a href="#1">Северная долина</a>
                <a href="#1">ЖК Шуваловский</a>
                <a href="#1">Просвещения 99</a> -->
            </div>
        </div>
    </div>
    <br>
    <!--     <div class="container">
            <p class="pull-left">&copy; Машиноместо </p>

            <p class="pull-right">Разработка и поддержка сайта <a href="nbm-it.ru">NBM-it</a></p>
        </div> -->
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
