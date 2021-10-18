<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Metro */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metro-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'object_id')->textInput() ?>

    <?= $form->field($model, 'metro_id')->textInput() ?>

    <?= $form->field($model, 'metro_distance')->textInput() ?>

    <?= $form->field($model, 'metro_time')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
