<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmailHash */

$this->title = Yii::t('app', 'Create Email Hash');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Email Hashes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-hash-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
