<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\themes\redesign\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/redesign/assets/dist';
    public $css = [
        'https://fonts.googleapis.com/css?family=Arimo:400,400i,700',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        'css/prism.css',
        'css/style.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/prism.js',
        'js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];

    public function init()
    {
        parent::init();
        // resetting BootstrapAsset to not load own css files
        Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => [],
            'js' => []
        ];
    }
}
