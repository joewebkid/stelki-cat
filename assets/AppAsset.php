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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css',
        'css/noty.min.css',
        'css/site.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js',
        'https://api-maps.yandex.ru/2.1/?apikey=6364954d-ce8c-4c70-9f00-e2f737904c40&lang=ru_RU&mode=debug',
        'js/common.js',
        'js/admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
