<?php

namespace app\modules\api\controllers;

use yii\helpers\Markdown;
use yii\web\Controller;

class DocsController extends Controller
{
    public function actionIndex()
    {
        $docs = file_get_contents($this->module->basePath . '/docs/index.md');

        return $this->render('index', [
            'content' => Markdown::process($docs, 'gfm'),
        ]);
    }
    
}
