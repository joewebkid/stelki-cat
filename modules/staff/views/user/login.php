<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

// $asset = \app\themes\app\AppAsset::register($this);$asset->baseUrl . 
$this->title = 'Вход';
?>

<div class="card-header">
    <div class="auth-box__title"><?= Html::decode($this->title) ?></div>
</div>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'email',[
        'template' => '{label}{input}{error}'
    ])
    ->textInput(['maxlength' => true])
    ->label(Yii::t('app', 'E-Mail')) ?>

<?= $form->field($model, 'password',[
        'template' => '{label}{input}{error}'
    ])
    ->passwordInput(['maxlength' => true])
    ->label(Yii::t('app', 'Password')) ?>

<?php if (Yii::$app->has('recaptcha')): ?>
    <div class="form-group">
        <?= Yii::$app->recaptcha->inject($this)->widget ?>
    </div>
<?php endif; ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Войти'), ['class' => 'btn btn-primary']) ?>
</div>
<div class="form-group">
    <?= Html::a(Yii::t('app', 'Забыли пароль?'), ['user/password-recovery']) ?>
</div>
<?php ActiveForm::end(); ?>
