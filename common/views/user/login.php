<div class="container">
    <?php $form = yii\widgets\ActiveForm::begin([
        'action' => '/site/login',
        'method' => 'post',
        'id' => 'login-modal__form',
        'options' => ['class' => 'login-modal__form', 'name' => 'login-modal__form']
    ]); ?>

    <div class="form-group login-modal__form-group">
        <?= $form->field($model, 'email', ['template'=>'{input}{error}'])->textInput([
            'placeholder' => 'Логин'
        ])->label(false); ?>
    </div>

    <div class="form-group login-modal__form-group">
        <?= $form->field($model, 'password', ['template'=>'{input}{error}'])->passwordInput([
            'placeholder' => 'Пароль'
        ])->label(false); ?>
    </div>

    <?= yii\helpers\Html::submitButton('Войти', ['class' => 'btn login-modal__btn-enter']) ?>

    <div class="login-modal__links">
        <a href="">Забыли пароль?</a>
        <a href="/registration">Регистрация</a>
    </div>
    <div class="socials login-modal__socials">
        <div class="socials__social socials__social-vk">
            <i class="icon icon-vk"></i>
        </div>
        <div class="socials__social socials__social-fb">
            <i class="icon icon-fb"></i>
        </div>
        <div class="socials__social socials__social-ok">
            <i class="icon icon-ok"></i>
        </div>
    </div>
    <?php yii\widgets\ActiveForm::end(); ?>
</div>