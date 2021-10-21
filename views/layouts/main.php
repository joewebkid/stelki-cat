<?php

use yii\helpers\Html;
use app\widgets\Alert;


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="ru"> <!--<![endif]-->
<head>
<meta charset="utf-8">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="">

    <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="/css/style.min.css">
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <?= Alert::widget(); ?>
    <div class="wrapper">
		<div class="content">

            <?= $this->render('header', [], true) ?>

            <?= $content ?>

        </div>
        <?= $this->render('footer', [], true) ?>
    </div>
    <script src="https://unpkg.com/imask"></script>
    <script src='js/script.js'></script>
    <?php $this->endBody() ?>
</body>
<?php $this->endPage() ?>