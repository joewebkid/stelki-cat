<header class="header _container">
    <div class="header__content">
        <div class="header__icon-container">
            <a href="/">
                <picture>
                    <source srcset="img/icon/logo.webp" type="/images/webp">
                    <img class="header__icon-logo" alt="логотип" src="/images/icon/logo.png">
                </picture>
            </a>
        </div>
        <?= $this->render('menu', [], true) ?>
    </div>
</header>