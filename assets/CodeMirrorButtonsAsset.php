<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * CodeMirrorButtonsAsset is for buttons plugin for CodeMirror
 */
class CodeMirrorButtonsAsset extends AssetBundle
{
    public $sourcePath = '@bower/codemirror-buttons';

    public $js = [
        'buttons.js',
    ];
}
