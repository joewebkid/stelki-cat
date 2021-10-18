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
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css',
        'css/site.css',
        'css/admin.css',
    ];
    public $js = [
        'https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js',
        'https://api-maps.yandex.ru/2.1/?apikey=6364954d-ce8c-4c70-9f00-e2f737904c40&lang=ru_RU',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.full.min.js',
        'js/admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
