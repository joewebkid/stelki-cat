<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ObjectAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.2.2/css/swiper.min.css",
        'css/objects.css',
    ];
    public $js = [
        'https://api-maps.yandex.ru/2.1/?apikey=6364954d-ce8c-4c70-9f00-e2f737904c40&lang=ru_RU&mode=debug',
        "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js",
        "js/object.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
