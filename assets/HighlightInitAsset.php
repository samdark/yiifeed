<?php


namespace app\assets;

use yii\web\AssetBundle;

class HighlightInitAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $js = [
        'js/highlight-init.js',
    ];
    public $depends = [
        'app\assets\HighlightjsAsset',
    ];

}
