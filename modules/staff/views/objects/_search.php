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

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'coord_lat') ?>

    <?= $form->field($model, 'coord_len') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'region') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'district') ?>

    <?= $form->field($model, 'zone') ?>

    <?= $form->field($model, 'photos') ?>

    <?= $form->field($model, 'metro') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'area') ?>

    <?= $form->field($model, 'security') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'owner') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
