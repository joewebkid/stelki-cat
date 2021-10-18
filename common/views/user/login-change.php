<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Login change');
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

<?= $form->field($model, 'email')
    ->textInput(['maxlength' => true])
    ->label(Yii::t('app', 'New email')) ?>

<?= $form->field($model, 'password')
    ->passwordInput(['maxlength' => true])
    ->label(Yii::t('app', 'Current password')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Apply'), ['class' => 'btn']) ?>
    </div>
<?php ActiveForm::end(); ?>