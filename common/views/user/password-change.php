<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Password change');

$asset = \app\themes\app\AppAsset::register($this);
$form = ActiveForm::begin(); ?>
<div class="auth-box__header">
    <?= Html::a( 
        Html::img($asset->baseUrl . '/images/logo.png', 
        ['class' => 'auth-box__logo']),
        ['index/index'],
        ['class' => 'logo']) 
    ?>
    <div class="auth-box__title"><?= Html::encode($this->title) ?></div>
</div>

<?= $form->field($model, 'password_current')
    ->passwordInput(['maxlength' => true])
    ->label(Yii::t('app', 'Current password')) ?>

<?= $form->field($model, 'password_new')
    ->passwordInput(['maxlength' => true])
    ->label(Yii::t('app', 'New password')) ?>

<?= $form->field($model, 'password_new_repeat')
    ->passwordInput(['maxlength' => true])
    ->label(Yii::t('app', 'Confirm new password')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Apply'), ['class' => 'btn']) ?>
    </div>
<?php ActiveForm::end(); ?>
