<?php


namespace app\assets;


use yii\web\AssetBundle;

/**
 * CodeMirrorAsset groups assets for code editing areas
 */
class CodeMirrorAsset extends AssetBundle
{
    public $sourcePath = '@bower/codemirror';

    public $js = [
        'lib/codemirror.js',

        // langs to highlight in markdown blocks
        'mode/shell/shell.js',
        'mode/clike/clike.js',
        'mode/css/css.js',
        'mode/javascript/javascript.js',
        'mode/php/php.js',
        'mode/sass/sass.js',
        'mode/sql/sql.js',
        'mode/twig/twig.js',
        'mode/xml/xml.js',
        'mode/yaml/yaml.js',
        'mode/htmlmixed/htmlmixed.js',

        // markdown and gfm
        'mode/meta.js',
        'mode/markdown/markdown.js',
        'addon/mode/overlay.js',
        'mode/gfm/gfm.js',
        'addon/edit/continuelist.js',


        // code editing goods
        'addon/fold/xml-fold.js',
        'addon/edit/matchbrackets.js',
        'addon/edit/closebrackets.js',
        'addon/edit/closetag.js',

        // for controls
        'addon/display/panel.js',
    ];

    public $css = [
        'lib/codemirror.css',
    ];
}
