<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\staff\models\Staff $model
 * @var yii\widgets\ActiveForm $form
 */

$this->title = Yii::t('app', 'Add new Administrator');

$asset = \app\themes\app\AppAsset::register($this);
?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'login')->textInput(['maxlength' => 255])->label(Yii::t('app', 'E-mail')) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Send invite'), ['class' => 'btn']) ?>
    </div>
<?php ActiveForm::end(); ?>
