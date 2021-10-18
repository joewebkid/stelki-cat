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

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <hr>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <hr>

    <div class="common-content grid">
        <div class="content-box content-box__object grid__cell grid__cell_size_6">
            <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'residential_сomplex_id')->dropDownList(Objects::getResidentialСomplexSelectMap(),[
                'class' => 'form-group__element form-group__text-input form-group__text-input--short',
            ]); ?>

            <?= $form->field($model, 'district')->dropDownList(Objects::getDistrictMap(),[
                'class' => 'form-group__element form-group__text-input form-group__text-input--short',
            ]); ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="content-box content-box__object grid__cell grid__cell_size_6">
            <div id="addresses__map" class="form-group form-group--full-width"></div>
            <?= $form->field($model, 'coord_lat')->hiddenInput(['maxlength' => true])->label(false) ?>

            <?= $form->field($model, 'coord_len')->hiddenInput(['maxlength' => true])->label(false) ?>
        </div>

        <div class="content-box content-box__object grid__cell grid__cell_size_6">

            <?= $form->field($model, 'metro')->textInput(['maxlength' => true]) ?>
            <div class="metroVis"></div>

            <?= $form->field($model, 'zone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'owner', ['template' => '<label>{label}{input}<span></span></label>{error}'])->checkbox([], false); ?>

            <?= $form->field($model, 'security', ['template' => '<label>{label}{input}<span></span></label>{error}'])->checkbox([], false); ?>

            <?php /*
            <?= $form->field($model, 'metro[]')->dropDownList(Metro::getStationMap(),[
                'class' => 'form-group__element form-group__text-input form-group__text-input--short',
                'multiple' => 'multiple' 
            ]); ?>
            */?>
            <div class="metro" data-metro='<?=$model->metro?>'></div>
        </div>
        <div class="content-box content-box__object grid__cell grid__cell_size_6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'description')->textArea(['maxlength' => true]) ?>

            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="content-box content-box__object grid__cell grid__cell_size_6">
            <?= $form->field($model, 'status')->dropDownList(Objects::getstatusMap(),[
                'class' => 'form-group__element form-group__text-input form-group__text-input--short',
            ]); ?>
            
            <?= $form->field($model, 'type')->dropDownList(Objects::getTypeMap(),[
                'class' => 'form-group__element form-group__text-input form-group__text-input--short',
            ]); ?>
            
            <?= $form->field($model, 'saleType', ['template' => '<div>{label}{input}<label class="adminObject" for="objects-saletype">
                <div class="typeChooser">Продажа</div>
                <div class="typeChooser">Аренда</div>
            </label></div>'])->checkbox([], false)->label('Форма договора'); ?>

            <?= $form->field($model, 'user_id')->dropDownList(Objects::getUsersMap(),[
                'class' => 'form-group__element form-group__text-input form-group__text-input--short',
            ]); ?>
        </div>
        <div class="content-box content-box__object grid__cell grid__cell_size_6">
            <?php
            if($model->photosArray) {
                foreach ($model->photosArray as $key => $value) {
                  ?><img class="photosClass" src="/uploads/<?=$value?>"> <?php 
                } 
            }
            ?>
            <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Загрузите фотографии (новые фотографии заменят старые)') ?>
        </div>
    </div>


    <hr>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <br>

    <?php ActiveForm::end(); ?>

</div>
