<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Objects;
use app\models\Metro;

/* @var $this yii\web\View */
/* @var $model app\models\Objects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="objects-form__user container">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <div class="common-content grid">
        <div class="content-box content-box__object grid__cell  grid__cell_size_12 steps step_1 active">
            <div class="content-box__heading">Тип объявления</div>
            <div class="grid__size_3">
                <?= $form->field($model, 'owner', ['template' => '<div>{label}{input}<label class="adminObject ' . ($model->id ? 'active' : '') . '" for="objects-owner">
                    <div class="typeChooser">Собственник</div>
                    <div class="typeChooser">Агенство</div>
                </label></div>'])->checkbox([], false)->label('Тип аккаунта'); ?>

                <?= $form->field($model, 'saleType', ['template' => '<div>{label}{input}<label class="adminObject ' . ($model->id ? 'active' : '') . '" for="objects-saletype">
                    <div class="typeChooser">Продажа</div>
                    <div class="typeChooser">Аренда</div>
                </label></div>'])->checkbox([], false)->label('Тип Сделки'); ?>

                <?= $form->field($model, 'type')->dropDownList(Objects::getTypeMap(), [
                    'class' => 'form-group__element form-group__text-input form-group__text-input--short',
                ]); ?>
            </div>
        </div>
        <div class="content-box content-box__object grid__cell  grid__cell_size_12 steps step_2 <?= ($model->id ? 'active' : '') ?>">
            <div class="content-box__heading">Адрес</div>
            <div class="fullAddress">
                <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => 'Город'])->label(false) ?>
                <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Улица, дом, корпус'])->label(false) ?>
            </div>

            <div id="addresses__map" class="form-group form-group--full-width"></div>
            <?= $form->field($model, 'coord_lat')->hiddenInput(['maxlength' => true])->label(false) ?>

            <?= $form->field($model, 'coord_len')->hiddenInput(['maxlength' => true])->label(false) ?>

            <div class="grid" style="grid-template-columns: 1fr 1fr 1fr;">

                <?= $form->field($model, 'district')->dropDownList(Objects::getDistrictMap(), [
                    'class' => 'form-group__element form-group__text-input form-group__text-input--short',
                ]); ?>


                <?= $form->field($model, 'residential_сomplex_id')->dropDownList(Objects::getResidentialСomplexSelectMap(), [
                    'class' => 'form-group__element form-group__text-input form-group__text-input--short',
                ]); ?>
                <div>
                    <?= $form->field($model, 'metro')->textInput(['maxlength' => true])->label('') ?>
                    <div class="metroVis"></div>
                    <div class="metro" data-metro='<?= $model->metro ?>'></div>
                </div>
            </div>


        </div>

        <div class="content-box content-box__object grid__cell_size_12 dop__info steps step_3">
            <div class="content-box__heading">Дополнительная информация</div>
            <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>
            <input id="area_input" class="form-control area_input" value="<?= $model->area ?>"><span
                    class="right-label">м²</span>
            <?= $form->field($model, 'security', ['template' => '<label>{label}{input}<span></span></label>{error}'])->checkbox([], false); ?>

            <?= $form->field($model, 'description')->textArea(['maxlength' => true]) ?>

            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
            <input id="price_input" class="form-control price_input " value="<?= $model->price ?>"><span
                    class="right-label">₽</span>
            <?php
            if ($model->photosArray) {
                foreach ($model->photosArray as $key => $value) {
                    ?><img class="photosClass" src="/uploads/<?= $value ?>"> <?php
                }
            }
            ?>
            <?= $form->field($model, 'imageFiles[]', ['template' => '<div class="input__wrapper">
                    <label class="control-label" for="objects-price">Изображения</label>
                   {input}
                   <label for="objects-imagefiles" class="input__file-button">
                      <span class="input__file-icon-wrapper"><svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="upload" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="input__file-icon"><path fill="currentColor" d="M452 432c0 11-9 20-20 20s-20-9-20-20 9-20 20-20 20 9 20 20zm-84-20c-11 0-20 9-20 20s9 20 20 20 20-9 20-20-9-20-20-20zm144-48v104c0 24.3-19.7 44-44 44H44c-24.3 0-44-19.7-44-44V364c0-24.3 19.7-44 44-44h124v-99.3h-52.7c-35.6 0-53.4-43.1-28.3-68.3L227.7 11.7c15.6-15.6 40.9-15.6 56.6 0L425 152.4c25.2 25.2 7.3 68.3-28.3 68.3H344V320h124c24.3 0 44 19.7 44 44zM200 188.7V376c0 4.4 3.6 8 8 8h96c4.4 0 8-3.6 8-8V188.7h84.7c7.1 0 10.7-8.6 5.7-13.7L261.7 34.3c-3.1-3.1-8.2-3.1-11.3 0L109.7 175c-5 5-1.5 13.7 5.7 13.7H200zM480 364c0-6.6-5.4-12-12-12H344v24c0 22.1-17.9 40-40 40h-96c-22.1 0-40-17.9-40-40v-24H44c-6.6 0-12 5.4-12 12v104c0 6.6 5.4 12 12 12h424c6.6 0 12-5.4 12-12V364z" ></path></svg></span>
                      <span class="input__file-button-text">Выберите файл</span>
                   </label>
                </div>'])->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Загрузите фотографии') ?>
            <span>Максимальный размер одного фото не должен превышать 5 Мб. Максимум можно загрузить 7 фото. Допустимые фотрматы: JPEG, PNG</span>
        </div>
    </div>

    <?= $form->errorSummary($model); ?>

    <div class="form-group content-box button__div">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'disabled' => 'disabled']) ?>
    </div>
    <br>

    <?php ActiveForm::end(); ?>

</div>
