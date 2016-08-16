<?php

namespace app\assets;

use yii\web\AssetBundle;

class CodeMirrorButtonsAsset extends AssetBundle
{
    public $sourcePath = '@bower/codemirror-buttons';

    public $js = [
        'buttons.js',
    ];
}
