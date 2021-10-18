<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Objects;

/* @var $this yii\web\View */
/* @var $model app\models\ObjectsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="objects-search">

    <?php $form = ActiveForm::begin([
        'action' => ['search-by-map'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="filter">
    <div style="z-index: 1;position: relative;">


        <?= $form->field($model, 'saleType', ['template' => '<div>{input}<label class="filterBlock borderBottom" for="objectssearch-saletype">
            <div class="typeChooser">Продажа</div>
            <div class="typeChooser">Аренда</div>
        </label></div>'])->checkbox([], false); ?>

        <div class="filterBlock borderBottom filterBlockLong">           
            <?php  echo $this->render('../site/_search_form', compact('form', 'model')); ?>
        </div>

        <div class="filterBlock filterButton">
            <?= Html::a('К списку', ['/'], ['class' => 'btn btn-primary btn-on-map']) ?>
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="fade__block">
</div>
<!-- <pre>
    <?php
    // print_r($model);
    ?>
</pre> -->