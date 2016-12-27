<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css?v=1.9',
        'css/jquery.ui.notify.min.css',
        'icons/general-ui/flaticon.css',
    ];
    public $js = [
        'js/jquery.notify.min.js',
        'js/jquery.form.min.js',
        'js/site.js?v=1.9',
        'js/datatables.min.js',
        'js/dataTables.bootstrap.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
