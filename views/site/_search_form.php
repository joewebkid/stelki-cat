<?php 
use app\models\Objects;
?>

<div class="search__inner">
    <?= $form->field($model, 'district', [
        'options' => ['class' => '']
    ])->checkboxList(Objects::getDistrictMap(), [
        'placeholder' => "Район",
        'item' => function ($index, $label, $name, $checked, $value) {
            $checked = $checked ? 'checked' : '';
            return "<label class='sel__block' data-index='$index'>
                <div class='sel__checkboxes'>
                    <input type='checkbox' name='$name' value='$value' $checked>
                    <div class='substitute'></div>
                </div>
                <div class='sel__text'>$label</div>
            </label>";
        },
        'class' => 'filterInner',
        'separator' => false
    ])?>
</div>
<div class="search__inner">
    <?= $form->field($model, 'residential_сomplex_id', [
        'options' => ['class' => '']
    ])->checkboxList(Objects::getResidentialСomplexMap(), [
        'placeholder' => "ЖК",
        'item' => function ($index, $label, $name, $checked, $value) {
            $checked = $checked ? 'checked' : '';
            return "<label class='sel__block' data-index='$index'>
                <div class='sel__checkboxes'>
                    <input type='checkbox' name='$name' value='$value' $checked>
                    <div class='substitute'></div>
                </div>
                <div class='sel__text'>$label</div>
            </label>";
        },
        'class' => 'filterInner leftNull',
        'separator' => false
    ])?>
</div>
<div class="filterDouble">
    <?= $form->field($model, 'price_from',['options' => [
        'class'=>'fieldsInner'
    ]])->input('price_from', ['placeholder' => "Цена от",'class'=>'fields'])->label('') ?>
    <?= $form->field($model, 'price_to',['options' => [
        'class'=>'fieldsInner'
    ]])->input('price_to', ['placeholder' => "до",'class'=>'fields'])->label('') ?>
</div>
<div>
    <div class="search__inner">
        <?= $form->field($model, 'type', [
            'options' => ['class' => '']
        ])->checkboxList(Objects::getTypeMap(), [
            'placeholder' => "Тип",
            'item' => function ($index, $label, $name, $checked, $value) {
                $checked = $checked ? 'checked' : '';
                return "<label class='sel__block' data-index='$index'>
                    <div class='sel__checkboxes'>
                        <input type='checkbox' name='$name' value='$value' $checked>
                        <div class='substitute'></div>
                    </div>
                    <div class='sel__text'>$label</div>
                </label>";
            },
            'class' => 'filterInner',
            'separator' => false
        ])?>
    </div>
</div>
<div class="filterDouble">
    <?= $form->field($model, 'area_from',['options' => [
        'class'=>'fieldsInner'
    ]])->input('area_from', ['placeholder' => "Площадь от",'class'=>'fields'])->label('') ?>
    <?= $form->field($model, 'area_to',['options' => [
        'class'=>'fieldsInner'
    ]])->input('area_to', ['placeholder' => "до",'class'=>'fields'])->label('') ?>
</div>