<?php

use \yii\web\View;

$form = yii\widgets\ActiveForm::begin([
    'action' => '/',
    'method' => 'post',
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'options' => [
        'class' => 'sign-form',
        'name' => 'sign-form'
    ],
    'fieldConfig' => [
        'options' => ['class' => 'form-item']
    ],
    'errorSummaryCssClass' => 'help-block'
]);

if (!empty($model->getErrors())) {
    $this->registerJs('
        signErrorsBlock = document.getElementById("sign-form-errors");
        signErrorsBlock.scrollIntoView({block: "center", behavior: "smooth"});',
        View::POS_READY,
        'sign-form-script'
    );
}

?>
<?= $form->field($model, 'name', ['template' => '{input}{label}'])->textInput(['class' => 'form-item__input', 'type' => 'text'])
    ->label('Ваше имя', ['class' => 'form-label']) 
?>
<?= $form->field($model, 'phone', ['template' => '{input}{label}'])->textInput(['class' => 'form-item__input tel', 'type' => 'phone'])
    ->label('Ваш телефон', ['class' => 'form-label']) 
?>
<?= $form->field($model, 'email', ['template' => '{input}{label}'])->textInput(['class' => 'form-item__input', 'type' => 'email'])
    ->label('Ваша электронная почта', ['class' => 'form-label']) 
?>

<?= $form->errorSummary($model, ['header' => 'Пожалуйста, исправьте следующие ошибки:', 'id' => 'sign-form-errors']) ?>

<div class="form-item">
    <?= yii\helpers\Html::submitButton('Записаться', ['class' => 'btn']) ?>
</div>

<?php yii\widgets\ActiveForm::end(); ?>