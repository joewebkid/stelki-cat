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

$activeInputName = (mb_strlen($model->name) > 0) ? ' active' : '';
$activeInputPhone = (mb_strlen($model->phone) > 0) ? ' active' : '';
$activeInputEmail = (mb_strlen($model->email) > 0) ? ' active' : '';

?>
<?= $form->field($model, 'name', ['template' => '{input}{label}'])->textInput(
    [
        'class' => 'form-item__input' . $activeInputName, 
        'type' => 'text'
    ])
    ->label('Ваше имя', ['class' => 'form-label'])
?>
<?= $form->field($model, 'phone', ['template' => '{input}{label}'])->textInput(
    [
        'class' => 'form-item__input tel' . $activeInputPhone, 
        'type' => 'phone'
    ])
    ->label('Ваш телефон', ['class' => 'form-label'])
?>
<?= $form->field($model, 'email', ['template' => '{input}{label}'])->textInput(
    [
        'class' => 'form-item__input' . $activeInputEmail, 
        'type' => 'email'
    ])
    ->label('Ваша электронная почта', ['class' => 'form-label'])
?>

<?= $form->errorSummary($model, ['header' => 'Пожалуйста, исправьте следующие ошибки:', 'id' => 'sign-form-errors']) ?>

<div class="form-item">
    <?= yii\helpers\Html::submitButton('Записаться', ['class' => 'btn']) ?>
</div>

<?php yii\widgets\ActiveForm::end(); ?>