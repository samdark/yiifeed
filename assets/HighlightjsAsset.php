<?php

namespace app\assets;

use yii\web\AssetBundle;

class HighlightjsAsset extends AssetBundle
{

    public $sourcePath = '@vendor/bower/highlightjs';
    public $js = [
        'highlight.pack.js',
    ];
    public $css = [
        'styles/github.css',
    ];

}
