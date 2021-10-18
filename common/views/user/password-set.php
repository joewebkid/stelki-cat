<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$asset = \app\themes\app\AppAsset::register($this);

$this->title = Yii::t('app', 'Setting new password');
?>

<?php $form = ActiveForm::begin(); ?>
<div class="auth-box__header">
    <?= Html::a( 
        Html::img($asset->baseUrl . '/images/logo.png', 
        ['class' => 'auth-box__logo']),
        ['index/index'],
        ['class' => 'logo'])
    ?>
    <div class="auth-box__title"><?= Html::encode($this->title) ?></div>
</div>

    <?= $form->field($model, 'password')
        ->passwordInput(['maxlength' => true])
        ->label(Yii::t('app','New password')) ?>

    <?= $form->field($model, 'password_repeat')
        ->passwordInput(['maxlength' => true])
        ->label(Yii::t('app','Confirm new password')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Apply'), ['class' => 'btn']) ?>
    </div>
<?php ActiveForm::end(); ?>
