<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\StaticPages;

/* @var $this yii\web\View */
/* @var $model app\models\StaticPages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="static-pages-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <hr>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->dropDownList($model->activeArray);
    ?>

    <?= $form->field($model, 'position')->dropDownList($model->positionArray);
    ?>

    <?= $form->field($model, 'priority')->dropDownList($model->priorityArray());
    ?>

    <hr>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
