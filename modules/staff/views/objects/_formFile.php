<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Objects;
use app\models\Metro;

/* @var $this yii\web\View */
/* @var $model app\models\Objects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="objects-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'excelFile')->fileInput() ?>

    <button>Submit</button>

    <?php ActiveForm::end() ?>

</div>
