<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Staff');
?>

<div class="page page_type_signin">
    <div class="auth-box">
        <div class="auth-box__inner">
            <?php if (isset($model)): ?>
                <?= $this->render('_'.$scenario, ['model' => $model]) ?>
            <?php elseif (isset($text)): ?>
                <?= $this->render('_'.$scenario, ['text' => $text]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
