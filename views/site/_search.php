<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ObjectsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="objects-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="filter">
    <div style="z-index: 1;position: relative;">
        <h1 style="max-width: 680px!important;
            margin: 20px auto 28px;
            color: white;
            font-weight: 600;">Машиноместа в Санкт-Петербурге</h1>
        <div class="filterBlock borderBottom"><?= $form->field($model, 'saleType', ['template' => '<div>{input}<label class=" " for="objectssearch-saletype">
            <div class="typeChooser">Продажа</div>
            <div class="typeChooser">Аренда</div>
        </label></div>'])->checkbox([], false); ?></div>

        <div class="filterBlock borderBottom filterBlockLong">           
            <?php  echo $this->render('_search_form', compact('form', 'model')); ?>
        </div>
        <div class="filterBlock filterButton">
            <?= Html::a('По карте',['catalog/search-by-map'], ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        </div>

    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="fade__block">
</div>
